<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] === "admin") {

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Bem-vindo, Administrador!"
    ]);

} else {

    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
}