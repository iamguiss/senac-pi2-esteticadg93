<?php

session_start();    

$destruir = session_destroy();

echo json_encode([
    "sucesso" => $destruir,
    "mensagem" => $destruir ? "Logout realizado com sucesso" : "Falha ao realizar logout"
]);

