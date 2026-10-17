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
            usuarios.nome, servicos.nome_servico, 
            servicos.preco, agendamento.status,
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
        $sql = "SELECT * 
                FROM agendamento 
                WHERE data = :data 
                AND hora = :hora
                AND status NOT IN ('CANCELADO', 'NEGADO')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarAgendamento($id_user, $id_service, $status, $data, $hora, $local)
    {
        $sql = "INSERT INTO agendamento (id_user, id_service, status, data, hora, local)
        VALUES (:id_user, :id_service, :status, :data, :hora, :local)";
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
        if ($perfil === "cliente") {
            $sql = "UPDATE agendamento 
                    SET status = 'CANCELADO' 
                    WHERE id_agendamento = :id_agendamento 
                    AND id_user = :id_user";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->execute();
        } elseif ($perfil === "admin") {
            $sqlAdmin = "UPDATE agendamento 
                SET status = 'CANCELADO'
                WHERE id_agendamento = :id_agendamento";
            $stmt = $this->pdo->prepare($sqlAdmin);
            $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            return false;
        }
        return $stmt->rowCount() > 0;
    }

    public function verificarDisponibilidade($data, $hora, $id_agendamento)
    {
        $sql = "SELECT * FROM agendamento
                WHERE data = :data
                AND hora = :hora
                AND id_agendamento != :id_agendamento
                AND status NOT IN ('CANCELADO', 'NEGADO')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function remarcarAgendamento($data, $hora, $id_agendamento, $id_user)
    {
        $sql = "UPDATE agendamento
        SET data = :data, hora = :hora
        WHERE id_agendamento = :id_agendamento AND id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->bindParam(":hora", $hora, PDO::PARAM_STR);
        $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindParam(":id_agendamento", $id_agendamento, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        return $resultado;
    }
}
