<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

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

if (
    !is_array($dados) ||
    !isset($dados["id_agendamento"]) ||
    filter_var($dados["id_agendamento"], FILTER_VALIDATE_INT) === false ||
    (int) $dados["id_agendamento"] <= 0
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do agendamento inválido"
    ]);
    exit();
}

$idUsuario = $_SESSION["id_user"];
$perfil = $_SESSION["perfil"];
$idAgendamento = (int) $dados["id_agendamento"];

if ($perfil !== "cliente" && $perfil !== "admin") {
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

    $agendamento = new Agendamento($pdo);

    $resultado = $agendamento->cancelarAgendamento(
        $perfil,
        $idUsuario,
        $idAgendamento
    );

    if ($resultado) {
        http_response_code(200);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Agendamento cancelado com sucesso"
        ]);
    } else {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Não foi possível cancelar o agendamento"
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao cancelar o agendamento"
    ]);
}
