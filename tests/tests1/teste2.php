<?php
    require_once "../backend/config/conexao.php";

    $database = new Database();

    $pdo = $database->conectar();

    $resultadoConsulta = $pdo->query("SELECT * FROM usuarios");

    $dados = $resultadoConsulta->fetchAll(PDO::FETCH_ASSOC); 

    $resultado = [
        "sucesso" => true,
        "mensagem" => "Dados recebidos com sucesso",
        "dados" => $dados
    ];

    echo json_encode($resultado);
