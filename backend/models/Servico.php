
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
        $consulta = $this->pdo->query(
            "SELECT
                id_service,
                nome_servico,
                preco,
                ativo,
                categoria
            FROM servicos"
        );

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    public function cadastrarServico($nome_servico, $preco, $ativo, $categoria)
    {
        $sql = "INSERT INTO servicos
                (nome_servico, preco, ativo, categoria)
                VALUES
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
    
        $editar->execute([
            ":id_service" => $id_service,
            ":nome_servico" => $nome_servico,
            ":preco" => $preco,
            ":categoria" => $categoria
        ]);
    
        return $editar->rowCount() > 0;
    }
     

    public function alternarStatus($id_service)
    {
        $this->pdo->beginTransaction();

        try {
            $consulta = $this->pdo->prepare(
                "SELECT ativo
                 FROM servicos
                 WHERE id_service = :id_service
                 FOR UPDATE"
            );

            $consulta->execute([
                ":id_service" => $id_service
            ]);

            $servico = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$servico) {
                $this->pdo->rollBack();
                return null;
            }

            $novoStatus = ((int) $servico["ativo"] === 1) ? 0 : 1;

            $alterar = $this->pdo->prepare(
                "UPDATE servicos
                 SET ativo = :ativo
                 WHERE id_service = :id_service"
            );

            $alterar->execute([
                ":ativo" => $novoStatus,
                ":id_service" => $id_service
            ]);

            $this->pdo->commit();

            return $novoStatus;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }
}
