
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

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

if (
    !is_array($dados) ||
    !isset($dados["email"], $dados["senha"]) ||
    !is_string($dados["email"]) ||
    !is_string($dados["senha"]) ||
    trim($dados["email"]) === "" ||
    $dados["senha"] === ""
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Informe o email e a senha"
    ]);
    exit();
}

$email = trim($dados["email"]);
$senha = $dados["senha"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Email inválido"
    ]);
    exit();
}

try {
    require_once "../config/conexao.php";
    require_once "../models/Usuario.php";

    $database = new Database();
    $pdo = $database->conectar();

    $consultar = new Usuario($pdo);
    $usuario = $consultar->buscarPorEmail($email);

    if (
        $usuario &&
        password_verify($senha, $usuario["senha"]) &&
        in_array($usuario["perfil"], ["cliente", "admin"], true)
    ) {
        session_regenerate_id(true);

        $_SESSION["id_user"] = $usuario["id_user"];
        $_SESSION["perfil"] = $usuario["perfil"];

        http_response_code(200);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Login realizado com sucesso"
        ]);

    } else {
        http_response_code(401);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Email ou senha incorretos"
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro interno ao realizar login"
    ]);
}
