console.log("JS carregou");

fetch("../backend/controllers/usuario.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        nome: "cliente 1",
        email: "cliente1@teste.com",
        senha: "123456",
        cpf: "1234567890",
        sexo: "M",
        perfil: "cliente"
    })
})
.then(resposta => resposta.json())
.then(dados => {
    console.log("Resposta do PHP:", dados);
});