<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["sucesso" => false, "mensagem" => "Este endpoint aceita apenas GET"]);
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

if (!in_array($_SESSION["perfil"], ["cliente", "admin"], true)) {
    http_response_code(403);
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso negado"]);
    exit();
}

$idUsuario = $_SESSION["id_user"];

try {
    require_once __DIR__ . "/../config/conexao.php";
    require_once __DIR__ . "/../models/Agendamento.php";

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
