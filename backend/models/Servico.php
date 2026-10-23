<?php

class Servico
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function listarTodos()
    {
        $consulta = $this->pdo->query("SELECT * FROM servicos");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarServico($nome_servico, $preco, $ativo, $categoria)
    {
        $sql =
            "INSERT INTO servicos (nome_servico, preco, ativo, categoria) VALUES
        (:nome_servico, :preco, :ativo, :categoria)";

        $cadastrar = $this->pdo->prepare($sql);
        $cadastrar->bindParam(":nome_servico", $nome_servico, PDO::PARAM_STR);
        $cadastrar->bindParam(":preco", $preco, PDO::PARAM_STR);
        $cadastrar->bindParam(":ativo", $ativo, PDO::PARAM_INT);
        $cadastrar->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $cadastrar->execute();
        return $this->pdo->lastInsertId();
    }

    public function editarServico($id_service, $nome_servico, $preco, $categoria)
    {
        $sql = "UPDATE servicos
            SET nome_servico = :nome_servico,
                preco = :preco,
                categoria = :categoria
            WHERE id_service = :id_service";

        $editar = $this->pdo->prepare($sql);

        return $editar->execute([
            ":id_service" => $id_service,
            ":nome_servico" => $nome_servico,
            ":preco" => $preco,
            ":categoria" => $categoria
        ]);
    }
}
