<!-- Cabeçalho -->
<div align="center">

# ✨ Estética DG93

### Sistema web de gestão e agendamento de serviços

Projeto Integrador desenvolvido no SENAC com o objetivo de facilitar o agendamento de serviços e apoiar a organização dos atendimentos da Estética DG93.

<br />

![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-Interatividade-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-Banco_de_dados-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-Ambiente_local-FB7A24?style=for-the-badge&logo=apachefriends&logoColor=white)

<br />

[Sobre o projeto](#-sobre-o-projeto) · [Funcionalidades](#-funcionalidades) · [Tecnologias](#-tecnologias) · [Instalação](#-como-executar-localmente) · [Documentação](#-documentação)

</div>

---

## 📌 Sobre o projeto

A **Estética DG93** é uma aplicação web desenvolvida como parte do Projeto Integrador do SENAC. O sistema busca centralizar informações sobre serviços e apoiar o fluxo de agendamentos entre clientes e administração.

### 🎯 Objetivos

- Facilitar a consulta de serviços e preços.
- Permitir que clientes criem, consultem, cancelem e solicitem a remarcação de agendamentos.
- Verificar a disponibilidade de horários e reduzir conflitos.
- Fornecer uma base para a gestão administrativa de serviços e atendimentos.

## 🚀 Funcionalidades

### 👤 Clientes e autenticação

- Cadastro de clientes.
- Login e logout.
- Autenticação por sessão.
- Separação de acesso por perfil.
- Armazenamento de senhas com hash.

### 🧴 Serviços

- Listagem de serviços e consulta de preços.
- Cadastro de serviços pelo backend.

### 📅 Agendamentos

- Criação e listagem de agendamentos.
- Consulta de detalhes.
- Verificação de disponibilidade.
- Bloqueio de horários já ocupados.
- Cancelamento de agendamentos.
- Remarcação de agendamentos, com verificação de conflitos e vínculo com o usuário.

### 🛠️ Em desenvolvimento

- Alteração de status dos atendimentos.
- Edição, ativação e desativação de serviços.
- Recursos completos da área administrativa.
- Revisão geral de validações e padronização de respostas HTTP/JSON.

> O projeto está em desenvolvimento. A lista acima diferencia os recursos já implementados daqueles que ainda precisam ser concluídos ou revisados.

## 🧰 Tecnologias

| Tecnologia | Utilização |
|---|---|
| **PHP** | Processamento no servidor e endpoints do backend |
| **JavaScript** | Comunicação com o backend usando `fetch()` e JSON |
| **MySQL** | Persistência dos dados |
| **PDO** | Acesso ao banco de dados com consultas preparadas |
| **XAMPP** | Ambiente local de desenvolvimento |
| **Postman** | Testes das requisições HTTP e respostas JSON |
| **Git e GitHub** | Versionamento e hospedagem do código |

## 🗂️ Estrutura do projeto

```text
senac-pi2-esteticadg93/
├── backend/
│   ├── config/       # Configuração da conexão com o banco
│   ├── controllers/  # Endpoints e fluxo das requisições
│   ├── models/       # Consultas e operações com os dados
│   └── services/     # Serviços auxiliares do backend
├── database/
│   └── database.sql  # Script SQL do banco de dados
├── docs/             # Documentação do projeto
├── frontend/         # Arquivos da interface
├── postman/          # Materiais relacionados aos testes de API
├── tests/            # Arquivos de teste
└── README.md
```

## ⚙️ Como executar localmente

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) instalado.
- Apache e MySQL disponíveis no XAMPP.
- [Git](https://git-scm.com/) (opcional, para clonar o repositório).

### 1. Baixe o projeto

Pelo terminal:

```bash
git clone https://github.com/iamguiss/senac-pi2-esteticadg93.git
```

Coloque a pasta do projeto dentro do diretório `htdocs` do XAMPP. Se estiver usando Windows, normalmente será:

```text
C:\xampp\htdocs\senac-pi2-esteticadg93
```

### 2. Inicie o ambiente local

Abra o XAMPP e inicie os módulos **Apache** e **MySQL**.

### 3. Crie o banco de dados

1. Acesse o phpMyAdmin pelo endereço `http://localhost/phpmyadmin`.
2. Importe o arquivo `database/database.sql`.
3. Confira os dados de conexão no arquivo `backend/config/conexao.php` e ajuste-os conforme seu ambiente local, se necessário.

> **Atenção:** use apenas dados de teste no ambiente local. Não coloque senhas reais, credenciais de produção ou dados pessoais no repositório.

### 4. Acesse o projeto

Abra no navegador:

[`http://localhost/senac-pi2-esteticadg93/`](http://localhost/senac-pi2-esteticadg93/)

Se a interface ainda não tiver uma página inicial configurada, acesse os arquivos disponíveis na pasta `frontend/` e confira as instruções específicas de cada página.

## 🧪 Testes

Os endpoints do backend podem ser testados com o Postman, enviando JSON no corpo das requisições quando necessário. Os controladores recebem os dados, processam as operações e retornam respostas JSON.

Exemplo de corpo para criar um agendamento:

```json
{
  "id_service": 1,
  "data": "2026-10-22",
  "hora": "14:00:00",
  "local": "Unidade DG93"
}
```

O agendamento utiliza o usuário autenticado na sessão; por isso, faça login antes de testar endpoints que exigem autenticação. Não envie `id_user` no corpo se o endpoint obtém esse valor da sessão.

## 📚 Documentação

- [Banco de dados](docs/BANCO_DE_DADOS.md)
- [Troca de feedback entre projetos](docs/project-exchange.md)
- [Código-fonte do projeto](https://github.com/iamguiss/senac-pi2-esteticadg93)

---

<div align="center">

**Projeto Integrador · SENAC · Estética DG93**

Feito para aprender, desenvolver e evoluir continuamente. 💻

</div>
