<?php

class Database
{
    private $host = "localhost";
    private $dbname = "estetica_dg93";
    private $username = "root";
    private $password = "";

    public function conectar(): PDO
    {
        $pdo = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            $this->username,
            $this->password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
