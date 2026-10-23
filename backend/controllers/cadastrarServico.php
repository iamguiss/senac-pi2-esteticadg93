<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../config/conexao.php";
require_once __DIR__ . "/../models/Servico.php";

// Verifica o método HTTP
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit;
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit;
}

// Somente administradores podem cadastrar serviços
if ($_SESSION["perfil"] !== "admin") {
    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit;
}

// Recebe os dados enviados em JSON
$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

// Valida o JSON e os campos obrigatórios
if (
    !is_array($dados) ||
    !isset(
        $dados["nome_servico"],
        $dados["preco"],
        $dados["ativo"],
        $dados["categoria"]
    )
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados incompletos ou inválidos"
    ]);
    exit;
}

// Valida os tipos e valores recebidos
if (
    !is_string($dados["nome_servico"]) ||
    !is_string($dados["categoria"]) ||
    !is_numeric($dados["preco"]) ||
    !in_array($dados["ativo"], [0, 1, "0", "1", true, false], true)
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Verifique os dados informados"
    ]);
    exit;
}

$nome = trim($dados["nome_servico"]);
$categoria = trim($dados["categoria"]);
$preco = (float) $dados["preco"];
$ativo = (int) $dados["ativo"];


if (
    $nome === "" ||
    $categoria === "" ||
    $preco < 0 ||
    strlen($nome) > 50 ||
    strlen($categoria) > 50
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nome, categoria ou preço inválido"
    ]);
    exit;
}

try {

    $database = new Database();
    $pdo = $database->conectar();

    $servico = new Servico($pdo);

    $idServico = $servico->cadastrarServico(
        $nome,
        $preco,
        $ativo,
        $categoria
    );

    http_response_code(201);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Serviço cadastrado com sucesso",
        "id_servico" => $idServico
    ]);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao cadastrar serviço"
    ]);
}