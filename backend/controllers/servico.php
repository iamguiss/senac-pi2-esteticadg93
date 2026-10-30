
<?php

header("Content-Type: application/json; charset=UTF-8");

try {
    require_once "../config/conexao.php";
    require_once "../models/Servico.php";

    $database = new Database();
    $pdo = $database->conectar();

    $consultar = new Servico($pdo);
    $servicos = $consultar->listarTodos();

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Serviços recebidos com sucesso",
        "servicos" => $servicos
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar os serviços"
    ]);
}
