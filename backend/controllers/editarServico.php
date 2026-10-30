
<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este endpoint aceita apenas POST"
    ]);
    exit();
}

if (!isset($_SESSION["id_user"], $_SESSION["perfil"])) {
    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado"
    ]);
    exit();
}

if ($_SESSION["perfil"] !== "admin") {
    http_response_code(403);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Acesso negado"
    ]);
    exit();
}

$entrada = file_get_contents("php://input");
$dados = json_decode($entrada, true);

if (
    !is_array($dados) ||
    !isset(
        $dados["id_service"],
        $dados["nome_servico"],
        $dados["preco"],
        $dados["categoria"]
    )
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados incompletos ou inválidos"
    ]);
    exit();
}

if (
    !is_string($dados["nome_servico"]) ||
    !is_string($dados["categoria"]) ||
    (!is_string($dados["preco"]) && !is_numeric($dados["preco"]))
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Verifique os dados informados"
    ]);
    exit();
}

$idService = filter_var($dados["id_service"], FILTER_VALIDATE_INT);
$nome = trim($dados["nome_servico"]);
$categoria = trim($dados["categoria"]);
$preco = filter_var($dados["preco"], FILTER_VALIDATE_FLOAT);

if (
    !$idService ||
    $idService <= 0 ||
    $nome === "" ||
    $categoria === "" ||
    $preco === false ||
    !is_finite($preco) ||
    $preco < 0 ||
    strlen($nome) > 50 ||
    strlen($categoria) > 50
) {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados inválidos para editar o serviço"
    ]);
    exit();
}

try {
    require_once __DIR__ . "/../config/conexao.php";
    require_once __DIR__ . "/../models/Servico.php";

    $database = new Database();
    $pdo = $database->conectar();

    $servicoEditar = new Servico($pdo);

    $resultado = $servicoEditar->editarServico(
        $idService,
        $nome,
        $preco,
        $categoria
    );

    if (!$resultado) {
        http_response_code(404);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Serviço não encontrado ou nenhuma alteração realizada"
        ]);
        exit();
    }

    http_response_code(200);

    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Serviço editado com sucesso",
        "id_servico" => $idService
    ]);

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao editar serviço"
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro interno ao editar serviço"
    ]);
}
