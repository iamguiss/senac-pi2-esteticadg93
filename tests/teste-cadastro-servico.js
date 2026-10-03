console.log("JS de cadastro de serviço carregado");

fetch("../backend/controllers/cadastrarServico.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        nome_servico: "teste 3",
        preco: 100.00,
        ativo: 1,
        categoria: "Teste"
    })
})

.then(resposta => resposta.json())
.then(dados => {
    console.log("Resposta do PHP:", dados);
});