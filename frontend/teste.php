<?php

require_once '../backend/config/connection.php';

echo "Conexão bem-sucedida!<br>";

// Executa uma consulta
$resultado = $mysqli->query("SELECT * FROM usuarios");

$dados = $resultado->fetch_all(MYSQLI_ASSOC);

var_dump($dados);