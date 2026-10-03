<?php

require_once "../config/conexao.php";


$database = new Database();

$pdo = $database->conectar();

$consulta = $pdo->query("SELECT * FROM servicos");

$servicos = $consulta->fetchAll(PDO::FETCH_ASSOC);

$servicos = [
    "sucesso" => true,
    "mensagem" => "Serviços recebidos com sucesso",
    "servicos" => $servicos
];

echo json_encode($servicos);

