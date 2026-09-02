<?php
// Conexão ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "estetica_dg93");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
die("Erro na conexão: " . $mysqli->connect_error);
}

// Executa uma consulta
// $resultado = $mysqli->query("SELECT * FROM usuarios");

// Obtém os dados como array associativo
// $dados = $resultado->fetch_all(MYSQLI_ASSOC);