```php
<?php

class Dashboard
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function consultarAdmin()
    {
        $sql = "SELECT
            (SELECT COUNT(*) FROM usuarios WHERE perfil = 'cliente') AS total_clientes,
            (SELECT COUNT(*) FROM servicos WHERE ativo = 1) AS total_servicos,
            COUNT(*) AS total_agendamentos,
            SUM(CASE WHEN status = 'AGUARDANDO_CONFIRMACAO' THEN 1 ELSE 0 END) AS total_aguardando_confirmacao,
            SUM(CASE WHEN status = 'APROVADO' THEN 1 ELSE 0 END) AS total_aprovados,
            SUM(CASE WHEN status = 'EM_ANDAMENTO' THEN 1 ELSE 0 END) AS total_em_andamento,
            SUM(CASE WHEN status = 'CONCLUIDO' THEN 1 ELSE 0 END) AS total_concluidos,
            SUM(CASE WHEN status = 'NEGADO' THEN 1 ELSE 0 END) AS total_negados,
            SUM(CASE WHEN status = 'CANCELADO' THEN 1 ELSE 0 END) AS total_cancelados
            FROM agendamento";

        $consulta = $this->pdo->query($sql);

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function consultarCliente($id_user)
    {
        $sql = "SELECT
            COUNT(*) AS total_agendamentos,
            SUM(CASE WHEN status = 'AGUARDANDO_CONFIRMACAO' THEN 1 ELSE 0 END) AS total_aguardando_confirmacao,
            SUM(CASE WHEN status = 'EM_ANDAMENTO' THEN 1 ELSE 0 END) AS total_em_andamento,
            SUM(CASE WHEN status = 'CONCLUIDO' THEN 1 ELSE 0 END) AS total_concluidos
            FROM agendamento
            WHERE id_user = :id_user";

        $consulta = $this->pdo->prepare($sql);

        $consulta->execute([
            ":id_user" => $id_user
        ]);

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
