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

try {
    require_once "../config/conexao.php";
    require_once "../models/Agendamento.php";

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

    $idAgendamento = filter_var(
        $dados["id_agendamento"],
        FILTER_VALIDATE_INT
    );

    $data = $dados["data"];
    $hora = $dados["hora"];

    if (
        !$idAgendamento ||
        $idAgendamento <= 0 ||
        !is_string($data) ||
        !is_string($hora)
    ) {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Dados inválidos"
        ]);
        exit();
    }

    $dataValida = DateTime::createFromFormat("!Y-m-d", $data);

    if (
        !$dataValida ||
        $dataValida->format("Y-m-d") !== $data ||
        !preg_match("/^(?:[01]\d|2[0-3]):[0-5]\d$/", $hora)
    ) {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Data ou horário inválido"
        ]);
        exit();
    }

    $database = new Database();
    $pdo = $database->conectar();

    $idUsuario = (int) $_SESSION["id_user"];

    $remarcar = new Agendamento($pdo);

    $horarioOcupado = $remarcar->verificarDisponibilidade(
        $data,
        $hora,
        $idAgendamento
    );

    if ($horarioOcupado) {
        http_response_code(409);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Horário ocupado"
        ]);
        exit();
    }

    $resultado = $remarcar->remarcarAgendamento(
        $data,
        $hora,
        $idAgendamento,
        $idUsuario
    );

    if ($resultado) {
        http_response_code(200);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Agendamento remarcado com sucesso"
        ]);
    } else {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Não foi possível remarcar o agendamento"
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao remarcar o agendamento"
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro interno ao remarcar o agendamento"
    ]);
}