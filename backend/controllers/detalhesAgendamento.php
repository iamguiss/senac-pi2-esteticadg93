
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas GET"
    ]);
    exit();
}

if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$idAgendamento = filter_input(INPUT_GET, "id_agendamento", FILTER_VALIDATE_INT);

if (!$idAgendamento || $idAgendamento <= 0) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID do agendamento inválido"
    ]);
    exit();
}

try {
    require_once __DIR__ . "/../config/conexao.php";
    require_once __DIR__ . "/../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $agendamentoModel = new Agendamento($pdo);

    $idUsuario = $_SESSION["perfil"] === "admin"
        ? null
        : $_SESSION["id_user"];

    $agendamento = $agendamentoModel->detalhesAgendamentos(
        $idUsuario,
        $idAgendamento
    );

    if (!$agendamento) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Agendamento não encontrado"
        ]);
        exit();
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "agendamento" => $agendamento
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao consultar agendamento"
    ]);
}
