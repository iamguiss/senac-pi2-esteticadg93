<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexao.php";
require_once "../models/Servico.php";


$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);
;

if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];


try {
    $database = new Database();
    $pdo = $database->conectar();

    $servicoEditar = new Servico($pdo);


    if ($perfil == "admin") {
        $editarServico = $servicoEditar->editarServico(
            $dados["id_service"],
            $dados["nome_servico"],
            $dados["preco"],
            $dados["categoria"]
        );

        http_response_code(201);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Serviço editado com sucesso",
            "id_servico" => $editarServico
        ]);

    }
    exit();

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao editar  serviço"
    ]);
}

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
