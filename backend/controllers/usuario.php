<?php
require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

$dados = json_decode(file_get_contents("php://input"), true);



$cadastro = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, cpf, sexo, perfil) VALUES (:nome, :email, :senha, :cpf, :sexo, :perfil)");

$cadastro->bindParam(":nome", $dados["nome"]);
$cadastro->bindParam(":email", $dados["email"]);
$cadastro->bindParam(":senha", $dados["senha"]);
$cadastro->bindParam(":cpf", $dados["cpf"]);
$cadastro->bindParam(":sexo", $dados["sexo"]);
$cadastro->bindParam(":perfil", $dados["perfil"]);

// $cadastro->execute();

$resposta = [
    "sucesso" => true,
    "mensagem" => "Usuário cadastrado com sucesso"
];

echo json_encode($resposta);
