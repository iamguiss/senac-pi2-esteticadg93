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
    require_once "../models/Usuario.php";

    $database = new Database();
    $pdo = $database->conectar();

    $usuario = new Usuario($pdo);
    $clientes = $usuario->listarClientes();

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "clientes" => $clientes
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os clientes"
    ]);
}
