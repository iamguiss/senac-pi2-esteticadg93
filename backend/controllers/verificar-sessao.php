
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (isset($_SESSION["id_user"], $_SESSION["perfil"])) {

    $mensagem = $_SESSION["perfil"] === "admin"
        ? "Sessão ativa como administrador"
        : "Sessão ativa como usuário";

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => $mensagem,
        "id_user" => $_SESSION["id_user"],
        "perfil" => $_SESSION["perfil"]
    ]);

} else {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Sessão não ativa"
    ]);
}
