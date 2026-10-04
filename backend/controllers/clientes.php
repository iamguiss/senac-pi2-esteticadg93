<?php
session_start();

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();


if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuario não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];

if ($perfil === "admin") {
    $consultarCliente = $pdo->prepare(
        "SELECT id_user, nome, email, cpf, sexo, perfil
        FROM usuarios WHERE perfil = 'cliente' 
        "
    );
    $consultarCliente->execute();
    $clientes = $consultarCliente->fetchAll(PDO::FETCH_ASSOC);

} else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
    exit();
}

echo json_encode($clientes);