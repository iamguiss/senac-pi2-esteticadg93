fetch("teste2.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        mensagem: "Receber dados do PHP"
    })   
})
// Converte a resposta JSON do PHP para objeto JS - transforma dados JSON em objeto JS
.then(resultado => resultado.json())
.then(dados => {
    console.log(dados.dados);

});