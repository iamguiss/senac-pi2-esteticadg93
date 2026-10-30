
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

if ($_SESSION["perfil"] !== "admin") {
    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit();
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (
    !is_array($dados) ||
    !isset($dados["id_agendamento"], $dados["status"])
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos ou incompletos"
    ]);
    exit();
}

$idAgendamento = filter_var(
    $dados["id_agendamento"],
    FILTER_VALIDATE_INT
);

$status = $dados["status"];

$statusPermitidos = [
    "APROVADO",
    "NEGADO",
    "EM_ANDAMENTO",
    "CONCLUIDO",
    "CANCELADO"
];

if (
    !$idAgendamento ||
    $idAgendamento <= 0 ||
    !is_string($status) ||
    !in_array($status, $statusPermitidos, true)
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos"
    ]);
    exit();
}

try {
    require_once "../config/conexao.php";
    require_once "../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $agendamento = new Agendamento($pdo);

    $resultado = $agendamento->statusAtual(
        $idAgendamento,
        $status
    );

    if ($resultado) {
        http_response_code(200);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Status alterado com sucesso"
        ]);
    } else {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Agendamento não encontrado ou alteração não permitida"
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao alterar o status"
    ]);
}
