<?php
session_start();

if (isset($_SESSION["id_user"])) {
    $resposta = [
        "sucesso" => true,
        "mensagem" => "Sessão ativa",
        "id_user" => $_SESSION["id_user"],
        "perfil" => $_SESSION["perfil"]
    ];

    if ($_SESSION["perfil"] === "admin") {
        $resposta["mensagem"] = "Sessão ativa como administrador";
    } else {
        $resposta["mensagem"] = "Sessão ativa como usuário";
    }
} else {

    $resposta = [
        "sucesso" => false,
        "mensagem" => "Sessão não ativa"
    ];
}

echo json_encode($resposta);
