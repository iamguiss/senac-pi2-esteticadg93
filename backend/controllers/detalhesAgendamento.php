<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["id_user"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$idUsuario = $_SESSION["id_user"];

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (!is_array($dados) || !isset($dados["id_agendamento"]) || !filter_var($dados["id_agendamento"], FILTER_VALIDATE_INT) || (int) $dados["id_agendamento"] <= 0) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do agendamento inválido"
    ]);
    exit();
}

$idAgendamento = (int) $dados["id_agendamento"];

try {
    require_once "../config/conexao.php";
    require_once "../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $detalhesAgendamentos = new Agendamento($pdo);
    $detalhes = $detalhesAgendamentos->detalhesAgendamentos(
        $idAgendamento,
        $idUsuario
    );

    if (!$detalhes) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Agendamento não encontrado"
        ]);
        exit();
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "detalhes" => $detalhes
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os detalhes"
    ]);
}
