fetch("../backend/controllers/cadastrarAgendamento.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
    "id_user": 16,
    "id_service": 1,
    "status": "AGUARDANDO_CONFIRMACAO",
    "data": "2026-10-10",
    "hora": "14:00",
    "local": "Estética DG93"
    })
})
.then(resposta => resposta.json())
.then(dados => {
    console.log("Resposta do PHP:", dados);
});