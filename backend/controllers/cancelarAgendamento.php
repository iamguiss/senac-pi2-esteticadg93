    <?php

    session_start();
    require_once "../config/conexao.php";

    $database = new Database();
    $pdo = $database->conectar();



    if (!isset($_SESSION["perfil"])) {
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Usuário não está logado"
        ]);
        exit();
    }
    $idUsuario = $_SESSION["id_user"];
    $perfil = $_SESSION["perfil"];

    $entrada = file_get_contents("php://input");
    $dados = json_decode($entrada, true);

    if ($perfil === "cliente") {
        if (isset($dados["id_agendamento"]) && isset($idUsuario)) {
            $updateAgendamento = $pdo->prepare(
                "UPDATE agendamento SET status = 'cancelado' 
                WHERE id_agendamento = :id_agendamento AND id_user = :id_user"
            );
            $updateAgendamento->bindParam(":id_agendamento", $dados["id_agendamento"]);
            $updateAgendamento->bindParam(":id_user", $idUsuario);
            $updateAgendamento->execute();
            if ($updateAgendamento->rowCount() > 0) {
                $resposta = [
                    "sucesso" => true,
                    "mensagem" => "Agendamento cancelado com sucesso"
                ];
            } else {
                $resposta = [
                    "sucesso" => false,
                    "mensagem" => "Não foi possível cancelar o agendamento"
                ];
            }
        } else {
            $resposta = [
                "sucesso" => false,
                "mensagem" => "ID do agendamento não informado"
            ];
        }
    } elseif ($perfil === "admin") {
        $id_agendamento = $dados["id_agendamento"];

        $updateAgendamento = $pdo->prepare(
            "UPDATE agendamento 
            SET status = 'cancelado'
            WHERE id_agendamento = :id_agendamento"
        );

        $updateAgendamento->execute([
            ":id_agendamento" => $id_agendamento
        ]);
        if ($updateAgendamento->rowCount() > 0) {
            $resposta = [
                "sucesso" => true,
                "mensagem" => "Agendamento cancelado com sucesso"
            ];
        } else {
            $resposta = [
                "sucesso" => false,
                "mensagem" => "Não foi possível cancelar o agendamento"
            ];
        }
    } else {

        $resposta = [
            "sucesso" => false,
            "mensagem" => "Acesso negado"
        ];
    }
    echo json_encode($resposta);
