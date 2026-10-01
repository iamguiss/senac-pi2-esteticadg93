//Envia os dado JS para PHP

// fetch("../backend/controllers/teste.php", {
//     method: "POST",
//     headers: {
//         "Content-Type": "application/json"
//     },
//     body: JSON.stringify({
//         mensagem: "Olá, PHP"
//     })
// })
// .then(resposta => resposta.text())
// .then(dados => {
//     console.log(dados);
// });


// Envia dados JSON para o PHP
fetch("teste.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        mensagem: "Olá, PHP"
    })
})
// Converte a resposta JSON do PHP para objeto JS
.then(resposta => resposta.json())
.then(dados => {
    console.log(dados.mensagem);
});