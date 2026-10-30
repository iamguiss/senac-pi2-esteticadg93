
<?php

class Usuario
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT
                    id_user,
                    nome,
                    email,
                    senha,
                    cpf,
                    sexo,
                    perfil
                FROM usuarios
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $email, $senha, $cpf, $sexo, $perfil = "cliente")
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios
                    (nome, email, senha, cpf, sexo, perfil)
                VALUES
                    (:nome, :email, :senha, :cpf, :sexo, :perfil)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senhaHash, PDO::PARAM_STR);
        $stmt->bindValue(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->bindValue(":sexo", $sexo, PDO::PARAM_STR);
        $stmt->bindValue(":perfil", $perfil, PDO::PARAM_STR);

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function buscarDetalhesCliente($id_user)
    {
        $sql = "SELECT
                    id_user,
                    nome,
                    email,
                    cpf,
                    sexo,
                    perfil
                FROM usuarios
                WHERE id_user = :id_user
                AND perfil = 'cliente'
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarClientes()
    {
        $sql = "SELECT
                    id_user,
                    nome,
                    email,
                    cpf,
                    sexo,
                    perfil
                FROM usuarios
                WHERE perfil = 'cliente'
                ORDER BY nome ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
