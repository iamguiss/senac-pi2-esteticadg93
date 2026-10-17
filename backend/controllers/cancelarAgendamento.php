
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once "../models/Agendamento.php";

if (!isset($_SESSION["perfil"], $_SESSION["id_user"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (!is_array($dados) || !isset($dados["id_agendamento"])) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do agendamento não informado"
    ]);
    exit();
}

$idUsuario = $_SESSION["id_user"];
$perfil = $_SESSION["perfil"];

if ($perfil !== "cliente" && $perfil !== "admin") {
    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit();
}

try {
    $database = new Database();
    $pdo = $database->conectar();

    $agendamento = new Agendamento($pdo);

    $resultado = $agendamento->cancelarAgendamento(
        $perfil,
        $idUsuario,
        (int) $dados["id_agendamento"]
    );

    if ($resultado) {
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Agendamento cancelado com sucesso"
        ];
    } else {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Não foi possível cancelar o agendamento"
        ];
    }

    echo json_encode($resposta);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao cancelar o agendamento"
    ]);
}
echo json_encode($resposta);
