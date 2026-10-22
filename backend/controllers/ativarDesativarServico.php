<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit();
}

if (!isset($_SESSION["perfil"])) {
    http_response_code(401);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

if ($_SESSION["perfil"] !== "admin") {
    http_response_code(403);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit();
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (
    !is_array($dados) || !isset($dados["id_service"])
    || !filter_var($dados["id_service"], FILTER_VALIDATE_INT)
    || (int) $dados["id_service"] <= 0
) {

    http_response_code(400);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do serviço inválido"
    ]);
    exit();
}

try {
    $database = new Database();
    $pdo = $database->conectar();

    $id_service = (int) $dados["id_service"];

    $consulta = $pdo->prepare(
        "SELECT ativo FROM servicos
         WHERE id_service = :id_service"
    );

    $consulta->execute([
        ":id_service" => $id_service
    ]);

    $servico = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$servico) {
        http_response_code(404);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Serviço não encontrado"
        ]);
        exit();
    }

    $novoStatus = ((int) $servico["ativo"] === 1) ? 0 : 1;

    $alterar = $pdo->prepare(
        "UPDATE servicos
         SET ativo = :ativo
         WHERE id_service = :id_service"
    );

    $alterar->execute([
        ":ativo" => $novoStatus,
        ":id_service" => $id_service
    ]);

    echo json_encode([
        "sucesso" => true,
        "ativo" => $novoStatus,
        "mensagem" => $novoStatus === 1
            ? "Serviço ativado com sucesso"
            : "Serviço desativado com sucesso"
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao alterar o serviço"
    ]);
}
