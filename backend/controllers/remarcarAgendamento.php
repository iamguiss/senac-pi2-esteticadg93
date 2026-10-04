<?php

session_start();
require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

$idUsuario = $_SESSION["id_user"];

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

$consultarDisponibilidade = $pdo->prepare(
    "SELECT * FROM agendamento 
        WHERE data = :data 
        AND hora = :hora 
        AND status = 'agendado' 
        AND id_user != :id_user"
);
$consultarDisponibilidade->execute([
    ":data" => $dados["data"],
    ":hora" => $dados["hora"],
    ":id_user" => $idUsuario
]);
$horarioOcupado = $consultarDisponibilidade->fetch(PDO::FETCH_ASSOC);

if ($horarioOcupado) {
    $resposta = [
        "sucesso" => false,
        "mensagem" => "Horário ocupado"
    ];
} else {

    $remarcarAgendamento = $pdo->prepare(
        "UPDATE agendamento
        SET data = :data, hora = :hora
        WHERE id_agendamento = :id_agendamento AND id_user = :id_user"
    );
    $remarcarAgendamento->execute([
        ":data" => $dados["data"],
        ":hora" => $dados["hora"],
        ":id_agendamento" => $dados["id_agendamento"],
        ":id_user" => $idUsuario
    ]);

    if ($remarcarAgendamento->rowCount() > 0) {
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Agendamento remarcado com sucesso"
        ];
    } else {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Não foi possível remarcar o agendamento"
        ];
    }
}

echo json_encode($resposta);