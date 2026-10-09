<?php
session_start();

if (!isset($_SESSION["id_user"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuario nao esta logado"
    ]);
    exit();
}
$idUsuario = $_SESSION["id_user"];

require_once "../config/conexao.php";

$database = new Database();
$pdo = $database->conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (!isset($_SESSION["perfil"])) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

$perfil = $_SESSION["perfil"];

if ($perfil === "admin") {

    $consultarCliente = $pdo->query(
        "SELECT COUNT(*) as total_clientes
        FROM usuarios
        WHERE perfil = 'cliente';"
    );
    $resultadoClientes = $consultarCliente->fetch(PDO::FETCH_ASSOC);

    $consultarServico = $pdo->query(
        "SELECT COUNT(*) as total_servicos
        FROM servicos
        WHERE ativo = 1;"
    );
    $resultadoServicos = $consultarServico->fetch(PDO::FETCH_ASSOC);

    $consultarAgendamento = $pdo->query(
        "SELECT COUNT(*) as total_agendamentos
        FROM agendamento;"
    );
    $resultadoAgendamentos = $consultarAgendamento->fetch(PDO::FETCH_ASSOC);

    $consultarAguardandoConfirmacao = $pdo->query(
        "SELECT COUNT(*) as total_aguardando_confirmacao
        FROM agendamento
        WHERE status = 'AGUARDANDO_CONFIRMACAO';"
    );
    $resultadoAguardandoConfirmacao = $consultarAguardandoConfirmacao->fetch(PDO::FETCH_ASSOC);

    $consultarAprovado = $pdo->query(
        "SELECT COUNT(*) as total_aprovados
        FROM agendamento
        WHERE status = 'APROVADO';"
    );
    $resultadoAprovados = $consultarAprovado->fetch(PDO::FETCH_ASSOC);

    $consultarEmAndamento = $pdo->query(
        "SELECT COUNT(*) as total_em_andamento
        FROM agendamento
        WHERE status = 'EM_ANDAMENTO';"
    );
    $resultadoEmAndamento = $consultarEmAndamento->fetch(PDO::FETCH_ASSOC);

    $consultarConcluido = $pdo->query(
        "SELECT COUNT(*) as total_concluidos
        FROM agendamento
        WHERE status = 'CONCLUIDO';"
    );
    $resultadoConcluidos = $consultarConcluido->fetch(PDO::FETCH_ASSOC);

    $consultarNegado = $pdo->query(
        "SELECT COUNT(*) as total_negados
        FROM agendamento
        WHERE status = 'NEGADO';"
    );
    $resultadoNegados = $consultarNegado->fetch(PDO::FETCH_ASSOC);

    $consultarCancelado = $pdo->query(
        "SELECT COUNT(*) as total_cancelados
        FROM agendamento
        WHERE status = 'CANCELADO';"
    );
    $resultadoCancelados = $consultarCancelado->fetch(PDO::FETCH_ASSOC);

    $resposta = [
        "total_clientes" => $resultadoClientes["total_clientes"],
        "total_servicos" => $resultadoServicos["total_servicos"],
        "total_agendamentos" => $resultadoAgendamentos["total_agendamentos"],
        "total_aguardando_confirmacao" => $resultadoAguardandoConfirmacao["total_aguardando_confirmacao"],
        "total_aprovados" => $resultadoAprovados["total_aprovados"],
        "total_em_andamento" => $resultadoEmAndamento["total_em_andamento"],
        "total_concluidos" => $resultadoConcluidos["total_concluidos"],
        "total_negados" => $resultadoNegados["total_negados"],
        "total_cancelados" => $resultadoCancelados["total_cancelados"]
    ];
    echo json_encode($resposta);
} elseif ($perfil === "cliente") {


    // consultar agendamento cliente
    $consultarAgendamento = $pdo->prepare(
        "SELECT COUNT(*) as total_agendamentos
            FROM agendamento
            WHERE agendamento.id_user = :id_user;"
    );
    $consultarAgendamento->bindParam(":id_user", $idUsuario, PDO::PARAM_INT);
    $consultarAgendamento->execute();
    $agendamentoCliente = $consultarAgendamento->fetch(PDO::FETCH_ASSOC);


    // consultar aguardando confirmação cliente
    $consultarAguardandoConfirmacao = $pdo->prepare(
        "SELECT COUNT(*) as total_aguardando_confirmacao
        FROM agendamento
        WHERE status = 'AGUARDANDO_CONFIRMACAO' AND agendamento.id_user = :id_user;"
    );
    $consultarAguardandoConfirmacao->bindParam(":id_user", $idUsuario, PDO::PARAM_INT);
    $consultarAguardandoConfirmacao->execute();
    $aguardandoConfirmacao = $consultarAguardandoConfirmacao->fetch(PDO::FETCH_ASSOC);

    // Consultar Em andamento Cliente
    $consultarEmAndamento = $pdo->prepare(
        "SELECT COUNT(*) as total_em_andamento
        FROM agendamento
        WHERE status = 'EM_ANDAMENTO'
        AND agendamento.id_user = :id_user;"
    );
    $consultarEmAndamento->bindParam(":id_user", $idUsuario, PDO::PARAM_INT);
    $consultarEmAndamento->execute();
    $EmAndamento = $consultarEmAndamento->fetch(PDO::FETCH_ASSOC);
    
    // Consultar Concluidos Clientes
    $consultarConcluido = $pdo->prepare(
        "SELECT COUNT(*) as total_concluidos
        FROM agendamento
        WHERE status = 'CONCLUIDO'
        AND agendamento.id_user = :id_user;"
    );
    $consultarConcluido->bindParam(":id_user", $idUsuario, PDO::PARAM_INT);
    $consultarConcluido->execute();
    $Concluido = $consultarConcluido->fetch(PDO::FETCH_ASSOC);

    $resposta = [
        "total_agendamentos" => $agendamentoCliente["total_agendamentos"],
        "total_aguardando_confirmacao" => $aguardandoConfirmacao["total_aguardando_confirmacao"],
        "total_em_andamento" => $EmAndamento["total_em_andamento"],
        "total_concluidos" => $Concluido["total_concluidos"]
        
    ];

    echo json_encode($resposta);
}
