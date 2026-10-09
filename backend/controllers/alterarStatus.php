<?php
session_start();

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];

if ($perfil === "admin") {
    $id_agendamento = $dados["id_agendamento"];
    $novoStatus = $dados["status"];


    $consultaStatus  = $pdo->prepare(
        "SELECT status 
        FROM agendamento
        WHERE id_agendamento = :id_agendamento"
    );
    $consultaStatus->execute([
        ":id_agendamento" => $id_agendamento
    ]);
    $statusAtual = $consultaStatus->fetch(PDO::FETCH_ASSOC);

    if (!$statusAtual) {
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Agendamento não encontrado"
        ]);
        exit();
    }
    $resposta = [
        "sucesso" => false,
        "mensagem" => "Não é permitido alterar o status"
    ];

    switch ($statusAtual["status"]) {
        case "AGUARDANDO_CONFIRMACAO":
            if (
                $novoStatus  === "APROVADO" ||
                $novoStatus  === "NEGADO" ||
                $novoStatus  === "CANCELADO"
            ) {
                $alterarStatus = $pdo->prepare(
                    "UPDATE agendamento
                    SET status = :status
                    WHERE id_agendamento = :id_agendamento
                    "
                );
                $alterarStatus->execute([
                    ":id_agendamento" => $id_agendamento,
                    ":status" => $novoStatus
                ]);
                if ($alterarStatus->rowCount() > 0) {
                    $resposta = [
                        "sucesso" => true,
                        "mensagem" => "Status alterado"
                    ];
                } else {
                    $resposta = [
                        "sucesso" => false,
                        "mensagem" => "Não foi possivel alterar o status"
                    ];
                }
            }
            break;

        case "APROVADO":
            if (
                $novoStatus  === "EM_ANDAMENTO" ||
                $novoStatus  === "CANCELADO"
            ) {
                $alterarStatus = $pdo->prepare(
                    "UPDATE agendamento
                        SET status = :status
                        WHERE id_agendamento = :id_agendamento
                        "
                );
                $alterarStatus->execute([
                    ":id_agendamento" => $id_agendamento,
                    ":status" => $novoStatus
                ]);
                if ($alterarStatus->rowCount() > 0) {
                    $resposta = [
                        "sucesso" => true,
                        "mensagem" => "Status alterado"
                    ];
                } else {
                    $resposta = [
                        "sucesso" => false,
                        "mensagem" => "Não foi possivel alterar o status"
                    ];
                }
            }
            break;

        case "EM_ANDAMENTO":
            if (
                $novoStatus  === "CONCLUIDO" ||
                $novoStatus  === "CANCELADO"
            ) {
                $alterarStatus = $pdo->prepare(
                    "UPDATE agendamento
                        SET status = :status
                        WHERE id_agendamento = :id_agendamento
                        "
                );
                $alterarStatus->execute([
                    ":id_agendamento" => $id_agendamento,
                    ":status" => $novoStatus
                ]);
                if ($alterarStatus->rowCount() > 0) {
                    $resposta = [
                        "sucesso" => true,
                        "mensagem" => "Status alterado"
                    ];
                } else {
                    $resposta = [
                        "sucesso" => false,
                        "mensagem" => "Não foi possivel alterar o status"
                    ];
                }
            }
            break;
        case "CONCLUIDO":

            break;
        case "CANCELADO":

            break;
        case "NEGADO":

            break;
    }
} else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
    exit();
}


echo json_encode($resposta);
