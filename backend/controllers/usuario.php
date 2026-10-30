
<?php

header("Content-Type: application/json; charset=UTF-8");

function validarCPF($cpf)
{
    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;

        for ($i = 0; $i < $t; $i++) {
            $soma += (int) $cpf[$i] * (($t + 1) - $i);
        }

        $digito = ($soma * 10) % 11;

        if ($digito === 10) {
            $digito = 0;
        }

        if ($digito !== (int) $cpf[$t]) {
            return false;
        }
    }

    return true;
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
        "mensagem" => "Nenhum dado JSON válido recebido"
    ]);
    exit();
}

$camposObrigatorios = ["nome", "email", "senha", "cpf"];

foreach ($camposObrigatorios as $campo) {
    if (
        !isset($dados[$campo]) ||
        !is_string($dados[$campo]) ||
        trim($dados[$campo]) === ""
    ) {
        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Preencha todos os campos obrigatórios"
        ]);
        exit();
    }
}

$nome = trim($dados["nome"]);
$email = trim($dados["email"]);
$senha = $dados["senha"];
$cpf = preg_replace('/\D/', '', $dados["cpf"]);
$sexo = $dados["sexo"] ?? null;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "E-mail inválido"
    ]);
    exit();
}

if (strlen($senha) < 8) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "A senha deve possuir pelo menos 8 caracteres"
    ]);
    exit();
}

if (!validarCPF($cpf)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "CPF inválido"
    ]);
    exit();
}

if ($sexo !== null && !is_string($sexo)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Sexo inválido"
    ]);
    exit();
}

try {
    require_once "../config/conexao.php";
    require_once "../models/Usuario.php";

    $database = new Database();
    $pdo = $database->conectar();

    $cadastrarUsuario = new Usuario($pdo);

    $idUsuario = $cadastrarUsuario->cadastrar(
        $nome,
        $email,
        $senha,
        $cpf,
        $sexo,
        "cliente"
    );

    http_response_code(201);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Usuário cadastrado com sucesso",
        "id_usuario" => $idUsuario
    ]);

} catch (PDOException $e) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível cadastrar o usuário. Verifique se o e-mail ou CPF já estão cadastrados."
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro interno ao cadastrar usuário"
    ]);
}
