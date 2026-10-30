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

$idUsuario = $_SESSION["id_user"];
$perfil = $_SESSION["perfil"];

if ($perfil !== "admin" && $perfil !== "cliente") {
    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit();
}

try {
    require_once "../config/conexao.php";
    require_once "../models/Dashboard.php";

    $database = new Database();
    $pdo = $database->conectar();

    $dashboard = new Dashboard($pdo);

    if ($perfil === "admin") {
        $dados = $dashboard->consultarAdmin();
    } else {
        $dados = $dashboard->consultarCliente($idUsuario);
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "dados" => $dados
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os dados do dashboard"
    ]);
}
