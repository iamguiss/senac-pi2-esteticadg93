<?php
session_start();


if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] === "admin") {

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Bem-vindo, Administrador!"
    ]);
} else {

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado. Você não tem permissão para acessar esta página."
    ]);
}
