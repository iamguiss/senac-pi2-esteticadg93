<?php
require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$consultarAgendamento = $pdo->query(
    "SELECT 
    agendamento.id_agendamento, 
    usuarios.nome, servicos.nome_servico, 
    servicos.preco, agendamento.status,
    agendamento.data, 
    agendamento.hora, 
    agendamento.local 
    FROM agendamento 
    JOIN usuarios ON agendamento.id_user = usuarios.id_user 
    JOIN servicos ON agendamento.id_service = servicos.id_service");


$resposta = $consultarAgendamento->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resposta);
