<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once "../models/Usuario.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit;
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (
    !is_array($dados) ||
    empty($dados["email"]) ||
    !isset($dados["senha"]) ||
    $dados["senha"] === ""
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Informe o email e a senha"
    ]);
    exit;
}

$database = new Database();
$pdo = $database->conectar();

$consultar = new Usuario($pdo);
$usuario = $consultar->buscarPorEmail($dados["email"]);

if ($usuario && password_verify($dados["senha"], $usuario["senha"])) {

    session_regenerate_id(true);

    $_SESSION["id_user"] = $usuario["id_user"];
    $_SESSION["perfil"] = $usuario["perfil"];

    $resposta = [
        "sucesso" => true,
        "mensagem" => "Login realizado com sucesso"
    ];

} else {
    http_response_code(401);

    $resposta = [
        "sucesso" => false,
        "mensagem" => "Email ou senha incorretos"
    ];
}

echo json_encode($resposta);
