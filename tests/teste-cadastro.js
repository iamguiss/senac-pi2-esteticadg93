console.log("JS carregou");

fetch("../backend/controllers/usuario.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        nome: "teste3",
        email: "teste@teste.com",
        senha: "123456",
        cpf: "98765434211",
        sexo: "M",
        perfil: "cliente"
    })
})
.then(resposta => resposta.text())
.then(dados => {
    console.log("Resposta do PHP:", dados);
});