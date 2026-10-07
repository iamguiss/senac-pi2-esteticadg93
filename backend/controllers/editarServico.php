<?php

session_start();

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();


$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);;

if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];

if ($perfil === "admin") {

    $nome_servico = $dados["nome_servico"];
    $preco = $dados["preco"];
    $categoria = $dados["categoria"];
    $id_service = $dados["id_service"];


    $editarServico = $pdo->prepare(
        "UPDATE servicos
        SET nome_servico = :nome_servico,
            preco = :preco,
            categoria = :categoria
        WHERE id_service = :id_service
        "
    );
    $editarServico->execute([
        "nome_servico" => $nome_servico,
        "preco" => $preco,
        "categoria" => $categoria,
        "id_service" => $id_service
    ]);

    if ($editarServico->rowCount() > 0) {
        $resposta = [
            "sucesso" => true,
            "mensagem" => "Serviço alterado"
        ];
    } else {
        $resposta = [
            "sucesso" => false,
            "mensagem" => "Não foi possível editar o serviço"
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
