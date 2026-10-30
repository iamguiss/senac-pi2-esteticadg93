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

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (
    !is_array($dados) ||
    !isset($dados["id_user"]) ||
    filter_var($dados["id_user"], FILTER_VALIDATE_INT) === false ||
    (int) $dados["id_user"] <= 0
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do cliente inválido"
    ]);
    exit();
}

$idCliente = (int) $dados["id_user"];

try {
    require_once "../config/conexao.php";
    require_once "../models/Usuario.php";

    $database = new Database();
    $pdo = $database->conectar();

    $usuario = new Usuario($pdo);
    $cliente = $usuario->buscarDetalhesCliente($idCliente);

    if (!$cliente) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Cliente não encontrado"
        ]);
        exit();
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "cliente" => $cliente
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os dados do cliente"
    ]);
}
