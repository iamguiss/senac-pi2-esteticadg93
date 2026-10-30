
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit();
}

if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
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

if (!is_array($dados) || !isset($dados["id_service"])) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do serviço inválido"
    ]);
    exit();
}

$idServico = filter_var(
    $dados["id_service"],
    FILTER_VALIDATE_INT
);

if (!$idServico || $idServico <= 0) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do serviço inválido"
    ]);
    exit();
}

try {
    require_once __DIR__ . "/../config/conexao.php";
    require_once __DIR__ . "/../models/Servico.php";

    $database = new Database();
    $pdo = $database->conectar();

    $servico = new Servico($pdo);

    $novoStatus = $servico->alternarStatus($idServico);

    if ($novoStatus === null) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Serviço não encontrado"
        ]);
        exit();
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "ativo" => $novoStatus,
        "mensagem" => $novoStatus === 1
            ? "Serviço ativado com sucesso"
            : "Serviço desativado com sucesso"
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao alterar o serviço"
    ]);
}
