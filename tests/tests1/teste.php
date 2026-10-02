<?php
require_once "../backend/config/conexao.php";

$database = new Database();

$pdo = $database->conectar();

//Recebe dados JS
$dados = json_decode(file_get_contents("php://input"), true);
echo $dados["mensagem"];

//Envia dados JSON
$resposta = [
    "sucesso" => true,
    "mensagem" => "Olá, JavaScript"
];

echo json_encode($resposta);
