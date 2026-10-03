<?php

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit;
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);;

if (!$dados) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nenhum dado JSON recebido"
    ]);
    exit;
}


$cadastrarServico = $pdo->prepare("INSERT INTO servicos (nome_servico, preco, ativo, categoria) VALUES (:nome_servico, :preco, :ativo, :categoria)");


$cadastrarServico->bindParam(":nome_servico", $dados["nome_servico"], PDO::PARAM_STR);
$cadastrarServico->bindParam(":preco", $dados["preco"], PDO::PARAM_STR);
$cadastrarServico->bindParam(":ativo", $dados["ativo"], PDO::PARAM_STR);
$cadastrarServico->bindParam(":categoria", $dados["categoria"], PDO::PARAM_STR);

$cadastrarServico->execute();

$resposta = [
    "sucesso" => true,
    "mensagem" => "Serviço cadastrado com sucesso"
];

echo json_encode($resposta);