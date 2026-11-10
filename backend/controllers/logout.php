<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido"
    ]);
    exit();
}

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $parametros = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametros["path"],
        $parametros["domain"],
        $parametros["secure"],
        $parametros["httponly"]
    );
}

$destruir = session_destroy();

if ($destruir) {
    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Logout realizado com sucesso"
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Falha ao realizar logout"
    ]);
}