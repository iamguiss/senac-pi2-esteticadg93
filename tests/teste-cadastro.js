fetch("../backend/controllers/usuario.php",{
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },

    //Enviar dados de cadastro para o backend
    body: JSON.stringify({
        nome: "Teste",
        email: "teste@teste.com",
        senha: "123456",
        cpf: "12345678900",
        sexo: "M",
        perfil: "cliente"
    })
})
.then(resposta => resposta.json())
.then(dados => {
    console.log(dados);
});