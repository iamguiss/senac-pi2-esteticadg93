
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

$_SESSION = [];

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
