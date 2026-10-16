<?php

class Usuario
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $email, $senha, $cpf, $sexo, $perfil)
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, cpf, sexo, perfil) 
        VALUES (:nome, :email, :senha, :cpf, :sexo, :perfil)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":senha", $senhaHash, PDO::PARAM_STR);
        $stmt->bindParam(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->bindParam(":sexo", $sexo, PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $perfil, PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();

    }
}
