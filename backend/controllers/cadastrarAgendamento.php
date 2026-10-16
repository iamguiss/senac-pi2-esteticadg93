<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once "../models/Agendamento.php";

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

$database = new Database();
$pdo = $database->conectar();

$consultar = new Agendamento($pdo);
$verificarHorario = $consultar->verificarHorario(
    $dados["data"],
    $dados["hora"]
);
$horarioOcupado = $verificarHorario;

try {
    if ($horarioOcupado) {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "O horário já está ocupado"
        ];
        echo json_encode($resposta);
        exit();
    } else {
        $AgendamentoID = $consultar->cadastrarAgendamento(
            $_SESSION["id_user"],
            $dados["id_service"],
            "AGUARDANDO_CONFIRMACAO",
            $dados["data"],
            $dados["hora"],
            $dados["local"]
        );
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Agendamento cadastrado com sucesso"
        ];
        echo json_encode($resposta);
    }
} catch (Exception $e) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível cadastrar o usuário"
    ]);
}
