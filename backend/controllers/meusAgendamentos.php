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

try {
    require_once "../config/conexao.php";
    require_once "../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $meusAgendamentos = new Agendamento($pdo);
    $agendados = $meusAgendamentos->consultarMeusAgendamento($idUsuario);

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "agendamentos" => $agendados
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os agendamentos"
    ]);
}
