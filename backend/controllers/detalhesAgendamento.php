<?php

session_start();
require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

$idUsuario = $_SESSION["id_user"];

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

$idAgendamento = $dados["id_agendamento"];

$consultarAgendamento = $pdo->prepare(
    "SELECT 
    agendamento.id_agendamento, 
    usuarios.nome, servicos.nome_servico, 
    servicos.preco, agendamento.status,
    agendamento.data, 
    agendamento.hora, 
    agendamento.local 
    FROM agendamento 
    JOIN usuarios ON agendamento.id_user = usuarios.id_user 
    JOIN servicos ON agendamento.id_service = servicos.id_service
    WHERE agendamento.id_agendamento = :id_agendamento 
    AND agendamento.id_user = :id_user"
);

$consultarAgendamento->bindParam(":id_agendamento", $idAgendamento);
$consultarAgendamento->bindParam(":id_user", $idUsuario);

$consultarAgendamento->execute();

$agendamento  = $consultarAgendamento->fetch(PDO::FETCH_ASSOC);    

echo json_encode($agendamento);