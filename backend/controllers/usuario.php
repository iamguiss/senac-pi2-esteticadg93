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
$dados = json_decode($entrada, true);
$senhaHash = password_hash($dados["senha"], PASSWORD_DEFAULT);


if (!$dados) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nenhum dado JSON recebido"
    ]);
    exit;
}

$cadastro = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, sexo, perfil) VALUES (:nome, :email, :senha, :cpf, :sexo, :perfil)");

$cadastro->bindParam(":nome", $dados["nome"]);
$cadastro->bindParam(":email", $dados["email"]);
$cadastro->bindParam(":senha", $senhaHash);
$cadastro->bindParam(":cpf", $dados["cpf"]);
$cadastro->bindParam(":sexo", $dados["sexo"]);
$cadastro->bindParam(":perfil", $dados["perfil"]);

$cadastro->execute();

$resposta = [
    "sucesso" => true,
    "mensagem" => "Usuário cadastrado com sucesso"
];

echo json_encode($resposta);
