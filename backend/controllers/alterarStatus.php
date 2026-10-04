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
    $idAgendamento = $dados["id_agendamento"];
    $status = $dados["status"];;

    $alterarStatus = $pdo->prepare(
        "UPDATE agendamento
        SET status = :status
        WHERE id_agendamento = :id_agendamento
        "
    );
    $alterarStatus->execute([
        ":id_agendamento" => $idAgendamento,
        ":status" => $status
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
} else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
    exit();
}


echo json_encode($resposta);