<?php

require_once "../config/conexao.php";
require_once "../models/Servico.php";


$database = new Database();

$pdo = $database->conectar();

$consultar = new Servico($pdo);
$servicos = $consultar->listarTodos();

$resposta = [
    "sucesso" => true,
    "mensagem" => "Serviços recebidos com sucesso",
    "servicos" => $servicos
];

echo json_encode($resposta);

