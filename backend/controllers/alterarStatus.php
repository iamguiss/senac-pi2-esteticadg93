<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once("../models/Agendamento.php");

// Verificar se o usuário está autenticado
if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

// Somente administradores podem alterar status
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
    !is_array($dados) ||
    !isset($dados["id_agendamento"], $dados["status"]) ||
    !is_numeric($dados["id_agendamento"]) ||
    (int) $dados["id_agendamento"] <= 0 ||
    !is_string($dados["status"])
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos ou incompletos"
    ]);

    exit();
}

try {
    $database = new Database();
    $pdo = $database->conectar();

    $agendamento = new Agendamento($pdo);


    $resultado = $agendamento->statusAtual(
        (int) $dados["id_agendamento"],
        $dados["status"]
    );

    if ($resultado) {
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Status alterado com sucesso"
        ];
    } else {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Agendamento não encontrado ou alteração não permitida"
        ];
    }

    echo json_encode($resposta);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao alterar o status"
    ]);
}

