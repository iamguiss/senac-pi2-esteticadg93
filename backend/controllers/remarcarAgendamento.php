<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["id_user"])) {
    http_response_code(401);
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

require_once "../config/conexao.php";
require_once "../models/Agendamento.php";

try {
    $database = new Database();
    $pdo = $database->conectar();

    $idUsuario = $_SESSION["id_user"];

    $entrada = file_get_contents("php://input");
    $dados = json_decode($entrada, true);

    if (
        !is_array($dados) ||
        !isset($dados["data"], $dados["hora"], $dados["id_agendamento"])
    ) {
        http_response_code(400);
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Dados incompletos para remarcar o agendamento"
        ]);
        exit();
    }

    $remarcar = new Agendamento($pdo);

    $horarioOcupado = $remarcar->verificarDisponibilidade(
        $dados["data"],
        $dados["hora"],
        (int) $dados["id_agendamento"]
    );

    if ($horarioOcupado) {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Horário ocupado"
        ];
    } else {
        $resultado = $remarcar->remarcarAgendamento(
            $dados["data"],
            $dados["hora"],
            (int) $dados["id_agendamento"],
            (int) $idUsuario
        );

        if ($resultado) {
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

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao remarcar o agendamento"
    ]);
}
