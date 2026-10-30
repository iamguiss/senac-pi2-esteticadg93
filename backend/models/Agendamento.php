
<?php

class Agendamento
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function consultarAgendamentos()
    {
        $consulta = $this->pdo->query(
            "SELECT
                agendamento.id_agendamento,
                usuarios.nome,
                servicos.nome_servico,
                servicos.preco,
                agendamento.status,
                agendamento.data,
                agendamento.hora,
                agendamento.local
            FROM agendamento
            JOIN usuarios ON agendamento.id_user = usuarios.id_user
            JOIN servicos ON agendamento.id_service = servicos.id_service"
        );

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    public function verificarHorario($data, $hora)
    {
        $sql = "SELECT 1
                FROM agendamento
                WHERE data = :data
                AND hora = :hora
                AND status NOT IN ('CANCELADO', 'NEGADO')
                LIMIT 1";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
    
        $stmt->execute();
    
        return $stmt->fetchColumn() !== false;
    }
    


    public function cadastrarAgendamento($id_user, $id_service, $status, $data, $hora, $local)
    {
        $sql = "INSERT INTO agendamento
                (id_user, id_service, status, data, hora, local)
                VALUES
                (:id_user, :id_service, :status, :data, :hora, :local)";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindParam(":id_service", $id_service, PDO::PARAM_INT);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":local", $local, PDO::PARAM_STR);
    
        $stmt->execute();
    
        return $this->pdo->lastInsertId();
    }
    

    public function cancelarAgendamento($perfil, $id_user, $id_agendamento)
    {
        try {
            $sql = "UPDATE agendamento
                    SET status = 'CANCELADO'
                    WHERE id_agendamento = :id_agendamento
                    AND status IN ('AGUARDANDO_CONFIRMACAO', 'APROVADO')";
    
            if ($perfil !== "admin") {
                $sql .= " AND id_user = :id_user";
            }
    
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindValue(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
    
            if ($perfil !== "admin") {
                $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
            }
    
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
    
        } catch (PDOException $e) {
            return false;
        }
    }


    public function verificarDisponibilidade($data, $hora, $id_agendamento)
    {
        $sql = "SELECT 1
                FROM agendamento
                WHERE data = :data
                AND hora = :hora
                AND id_agendamento != :id_agendamento
                AND status NOT IN ('CANCELADO', 'NEGADO')
                LIMIT 1";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->fetchColumn() !== false;
    }
    


    public function remarcarAgendamento($data, $hora, $id_agendamento, $id_user)
    {
        $sql = "UPDATE agendamento
                SET data = :data,
                    hora = :hora
                WHERE id_agendamento = :id_agendamento
                AND id_user = :id_user
                AND status NOT IN ('CANCELADO', 'NEGADO', 'CONCLUIDO', 'EM_ANDAMENTO')";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
    }
    

    public function consultarStatus($id_agendamento)
    {
        $sql = "SELECT status
                FROM agendamento
                WHERE id_agendamento = :id_agendamento";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function alterarStatus($status, $id_agendamento)
    {
        $sql = "UPDATE agendamento
                SET status = :status
                WHERE id_agendamento = :id_agendamento";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function statusAtual($id_agendamento, $novoStatus)
    {
        $statusAtual = $this->consultarStatus($id_agendamento);

        if (!$statusAtual) {
            return false;
        }

        switch ($statusAtual["status"]) {
            case "AGUARDANDO_CONFIRMACAO":
                if (
                    $novoStatus === "APROVADO" ||
                    $novoStatus === "NEGADO" ||
                    $novoStatus === "CANCELADO"
                ) {
                    return $this->alterarStatus($novoStatus, $id_agendamento);
                }
                break;

            case "APROVADO":
                if (
                    $novoStatus === "EM_ANDAMENTO" ||
                    $novoStatus === "CANCELADO"
                ) {
                    return $this->alterarStatus($novoStatus, $id_agendamento);
                }
                break;

            case "EM_ANDAMENTO":
                if (
                    $novoStatus === "CONCLUIDO" ||
                    $novoStatus === "CANCELADO"
                ) {
                    return $this->alterarStatus($novoStatus, $id_agendamento);
                }
                break;
        }

        return false;
    }

    public function consultarMeusAgendamento($id_user)
    {
        $consulta = $this->pdo->prepare(
            "SELECT
                agendamento.id_agendamento,
                usuarios.nome,
                servicos.nome_servico,
                servicos.preco,
                agendamento.status,
                agendamento.data,
                agendamento.hora,
                agendamento.local
            FROM agendamento
            JOIN usuarios ON agendamento.id_user = usuarios.id_user
            JOIN servicos ON agendamento.id_service = servicos.id_service
            WHERE agendamento.id_user = :id_user"
        );

        $consulta->execute([
            ":id_user" => $id_user
        ]);

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    public function detalhesAgendamentos($id_user, $id_agendamento)
    {
        $sql = "SELECT
                    agendamento.id_agendamento,
                    usuarios.nome,
                    servicos.nome_servico,
                    servicos.preco,
                    agendamento.status,
                    agendamento.data,
                    agendamento.hora,
                    agendamento.local
                FROM agendamento
                JOIN usuarios ON agendamento.id_user = usuarios.id_user
                JOIN servicos ON agendamento.id_service = servicos.id_service
                WHERE agendamento.id_agendamento = :id_agendamento";
    
        if ($id_user !== null) {
            $sql .= " AND agendamento.id_user = :id_user";
        }
    
        $consulta = $this->pdo->prepare($sql);
    
        $parametros = [
            ":id_agendamento" => $id_agendamento
        ];
    
        if ($id_user !== null) {
            $parametros[":id_user"] = $id_user;
        }
    
        $consulta->execute($parametros);
    
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    
}
