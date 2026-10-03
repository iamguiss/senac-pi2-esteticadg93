fetch("../backend/controllers/login.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        email: "cliente@teste.com",
        senha: "123456"
    })
})
.then(resposta => resposta.json())
.then(dados => {
    console.log(dados);
});