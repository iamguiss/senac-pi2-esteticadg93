<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

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

try {
    require_once "../config/conexao.php";
    require_once "../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $consultar = new Agendamento($pdo);
    $agendamentos = $consultar->consultarAgendamentos();

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "agendamentos" => $agendamentos
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os agendamentos"
    ]);
}
