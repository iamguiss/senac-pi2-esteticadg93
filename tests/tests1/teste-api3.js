// GET já é o método padrão do fetch() - sem necessidade do uso do {}

fetch("teste3.php")
// Converte a resposta JSON do PHP para objeto JS - transforma dados JSON em objeto JS
.then(resultado => resultado.json())
.then(dados => {
    console.log(dados.dados);

});