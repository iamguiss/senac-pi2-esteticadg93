<?php

class Servico {
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function listarTodos(){
        $consulta = $this->pdo->query("SELECT * FROM servicos");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
