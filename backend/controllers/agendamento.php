<?php

require_once "../config/conexao.php";
require_once "../models/Agendamento.php";

$database = new Database();
$pdo = $database->conectar();

$consultar = new Agendamento($pdo);
$agendamentos = $consultar->consultarAgendamentos();

header("Content-Type: application/json; charset=UTF-8");

echo json_encode($agendamentos);