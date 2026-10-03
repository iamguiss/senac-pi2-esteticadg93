<?php

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);


//Consultar se o horario já está ocupado
$verificarHorario = $pdo->prepare(
    "SELECT * 
    FROM agendamento 
    WHERE data = :data 
    AND hora = :hora");
$verificarHorario->bindParam(":data", $dados["data"], PDO::PARAM_STR);
$verificarHorario->bindParam(":hora", $dados["hora"], PDO::PARAM_STR);
$verificarHorario->execute();

$horarioOcupado = $verificarHorario->fetch(PDO::FETCH_ASSOC);

if ($horarioOcupado) {
    $resposta = [
        "sucesso" => false,
        "mensagem" => "O horário já está ocupado"
    ];
    echo json_encode($resposta);
    exit();
} else {

    // registrar um agendamento no banco de dados caso o horário esteja disponível
    $cadastrarAgendamento = $pdo->prepare("INSERT INTO agendamento (id_user, id_service, status, data, hora, local) VALUES (:id_user, :id_service, :status, :data, :hora, :local)");

    $cadastrarAgendamento->bindParam(":id_user", $dados["id_user"], PDO::PARAM_INT);
    $cadastrarAgendamento->bindParam(":id_service", $dados["id_service"], PDO::PARAM_INT);
    $cadastrarAgendamento->bindParam(":status", $dados["status"], PDO::PARAM_STR);
    $cadastrarAgendamento->bindParam(":data", $dados["data"], PDO::PARAM_STR);
    $cadastrarAgendamento->bindParam(":hora", $dados["hora"], PDO::PARAM_STR);
    $cadastrarAgendamento->bindParam(":local", $dados["local"], PDO::PARAM_STR);

    $cadastrarAgendamento->execute();
}

$resposta = [
    "sucesso" => true,
    "mensagem" => "Agendamento cadastrado com sucesso"
];

echo json_encode($resposta);
