fetch("../backend/controllers/servico.php",{
    method: "GET",
})

.then(servicos => servicos.json())
.then(dados => {
    console.log(dados.servicos);     
});