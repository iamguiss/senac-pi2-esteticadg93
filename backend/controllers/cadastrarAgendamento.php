
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["id_user"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "É necessário estar logado para realizar um agendamento"
    ]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit();
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (!is_array($dados)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos"
    ]);
    exit();
}

if (
    !isset($dados["id_service"], $dados["data"], $dados["hora"], $dados["local"]) ||
    !is_string($dados["data"]) ||
    !is_string($dados["hora"]) ||
    !is_string($dados["local"])
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha todos os campos obrigatórios"
    ]);
    exit();
}

$idService = filter_var($dados["id_service"], FILTER_VALIDATE_INT);
$data = $dados["data"];
$hora = $dados["hora"];
$local = trim($dados["local"]);

if (!$idService || $idService <= 0) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Serviço inválido"
    ]);
    exit();
}

if (
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data) ||
    !checkdate(
        (int) substr($data, 5, 2),
        (int) substr($data, 8, 2),
        (int) substr($data, 0, 4)
    )
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Data inválida"
    ]);
    exit();
}

if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $hora)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Horário inválido"
    ]);
    exit();
}

if ($local === "") {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Informe o local do atendimento"
    ]);
    exit();
}

try {
    require_once __DIR__ . "/../config/conexao.php";
    require_once __DIR__ . "/../models/Agendamento.php";

    $database = new Database();
    $pdo = $database->conectar();

    $consultar = new Agendamento($pdo);

    $horarioOcupado = $consultar->verificarHorario(
        $data,
        $hora
    );

    if ($horarioOcupado) {
        http_response_code(409);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "O horário já está ocupado"
        ]);
        exit();
    }

    $agendamentoID = $consultar->cadastrarAgendamento(
        $_SESSION["id_user"],
        $idService,
        "AGUARDANDO_CONFIRMACAO",
        $data,
        $hora,
        $local
    );

    http_response_code(201);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Agendamento cadastrado com sucesso",
        "id_agendamento" => $agendamentoID
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível cadastrar o agendamento"
    ]);
}
