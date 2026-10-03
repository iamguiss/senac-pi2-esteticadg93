<?php

session_start();

if (!isset($_SESSION["id_user"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuario nao esta logado"
    ]);
    exit();
}
$idUsuario = $_SESSION["id_user"];

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();


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
    WHERE agendamento.id_user = :id_user"
);

$consultarAgendamento->bindParam(":id_user", $idUsuario, PDO::PARAM_INT);
$consultarAgendamento->execute();

$agendamentos = $consultarAgendamento->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($agendamentos);
