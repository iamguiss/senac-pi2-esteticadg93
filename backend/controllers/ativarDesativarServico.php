<?php
session_start();

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit;
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);;

if (!$dados) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nenhum dado JSON recebido"
    ]);
    exit;
}


if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];

if ($perfil === "admin") {
    $id_service = $dados["id_service"];

    $consultarAtivos = $pdo->prepare(
        "SELECT ativo 
        FROM servicos 
        WHERE id_service = :id_service
        "
    );

    $consultarAtivos->execute([
        ":id_service" => $dados["id_service"]
    ]);
    $ativo = $consultarAtivos->fetch(PDO::FETCH_ASSOC);

    $valorAtivo = $ativo["ativo"];

    if ($valorAtivo == "1") {
        $alterarAtivos = $pdo->prepare(
            "UPDATE servicos 
            SET ativo = 0
            WHERE id_service = :id_service"
        );
    } else {
        $alterarAtivos = $pdo->prepare(
            "UPDATE servicos 
            SET ativo = 1
            WHERE id_service = :id_service"
        );
    }
    $alterarAtivos->execute([
        ":id_service" => $id_service
    ]);

    if ($alterarAtivos->rowCount() > 0) {
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Ativo"
        ];
    } else {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Não foi possivel alterar"
        ];
    }
}else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
    exit();
}


echo json_encode($resposta);
