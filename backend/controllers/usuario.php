<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once "../models/Usuario.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit;
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (!is_array($dados)) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nenhum dado JSON válido recebido"
    ]);
    exit;
}

$database = new Database();
$pdo = $database->conectar();

$cadastrarUsuario = new Usuario($pdo);

try {
    $idUsuario = $cadastrarUsuario->cadastrar(
        $dados["nome"],
        $dados["email"],
        $dados["senha"],
        $dados["cpf"],
        $dados["sexo"] ?? null,
        "cliente"
    );

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Usuário cadastrado com sucesso",
        "id_usuario" => $idUsuario
    ]);

} catch (PDOException $e) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível cadastrar o usuário"
    ]);
}
