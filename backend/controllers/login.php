<?php
session_start();

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);


//Consultar email e senha no banco de dados do usuário
$consultar = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");

$consultar->bindParam(":email", $dados["email"]);
//$consultar->bindParam(":senha", $dados["senha"]);

$consultar->execute();

$usuario = $consultar->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($dados["senha"], $usuario["senha"])) {

    $_SESSION["id_user"] = $usuario["id_user"];
    $_SESSION["perfil"] = $usuario["perfil"];

    $resposta = [
        "sucesso" => true,
        "mensagem" => "Login realizado com sucesso",
    ];
} else {
    $resposta = [
        "sucesso" => false,
        "mensagem" => "Email ou senha incorretos"
    ];
}

echo json_encode($resposta);
