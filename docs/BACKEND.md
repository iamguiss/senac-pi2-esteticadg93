# Backend — Estética DG93

## Objetivo

Desenvolver o backend do sistema utilizando PHP e MySQL, realizando a comunicação entre o frontend, o servidor e o banco de dados.

O backend é responsável pelo processamento das requisições, manipulação dos dados, autenticação dos usuários, gerenciamento dos serviços e controle dos agendamentos.

## Arquitetura

O sistema utiliza a seguinte estrutura de comunicação:

```text
HTML + CSS + JavaScript
        ↓
      fetch()
        ↓
       JSON
        ↓
       PHP
        ↓
    Controllers
        ↓
      Models
        ↓
      MySQL
```

As respostas do backend são retornadas em JSON para serem interpretadas pelo JavaScript.

### Fluxo de comunicação

```text
JavaScript
    ↓
  fetch()
    ↓
   JSON
    ↓
    PHP
    ↓
Processamento
    ↓
   Model
    ↓
   MySQL
    ↓
   Model
    ↓
Controller
    ↓
   JSON
    ↓
JavaScript
    ↓
   HTML
```

## Estrutura do Backend

```text
backend/
├── config/
│   └── conexao.php
├── controllers/
├── models/
└── services/
```

- **Config:** responsável pelas configurações e conexão com o banco de dados.
- **Controllers:** recebem e processam as requisições do frontend.
- **Models:** responsáveis pelas consultas SQL e manipulação dos dados.
- **Services:** destinados às regras e operações específicas da aplicação.

## Comunicação Frontend → Backend

O JavaScript realiza requisições ao PHP utilizando `fetch()`.

Os dados enviados pelo frontend são organizados no formato JSON.

O PHP recebe os dados utilizando `json_decode()` e retorna as informações utilizando `json_encode()`.

### Teste de comunicação realizado

Foi realizado um teste de comunicação entre JavaScript e PHP utilizando `fetch()` e JSON.

O JavaScript enviou dados em JSON para o PHP. O PHP recebeu os dados utilizando `json_decode()`, processou a informação e retornou uma resposta utilizando `json_encode()`.

O JavaScript recebeu e interpretou a resposta utilizando `response.json()`.

## Banco de Dados

O backend utiliza o banco de dados:

`estetica_dg93`

A conexão com o banco de dados é realizada através do arquivo:

`backend/config/conexao.php`

A estrutura do banco está documentada em:

`docs/BANCO_DE_DADOS.md`

### Principais tabelas

- `usuarios`
- `servicos`
- `agendamento`

## Etapas do Desenvolvimento

### 1. Comunicação entre JavaScript e PHP

- [x] Criar primeiro endpoint PHP.
- [x] Enviar dados pelo JavaScript.
- [x] Enviar dados em JSON.
- [x] Receber JSON no PHP.
- [x] Processar a requisição.
- [x] Retornar resposta em JSON.
- [x] Interpretar resposta no JavaScript.
- [x] Testar comunicação.

### 2. Usuários

- [x] Cadastro de cliente.
- [x] Login.
- [x] Logout.
- [x] Autenticação.
- [x] Controle de acesso.
- [x] Separação entre cliente e administrador.
- [x] Perfil do usuário.
- [x] Hash de senha.

### 3. Serviços

- [x] Listar serviços.
- [x] Consultar valores.
- [x] Cadastrar serviço.
- [x] Editar serviço.
- [x] Alterar valores.
- [x] Ativar serviço.
- [x] Desativar serviço.

### 4. Agendamentos

- [x] Criar agendamento.
- [x] Selecionar serviço.
- [x] Selecionar data.
- [x] Selecionar horário.
- [x] Verificar disponibilidade.
- [x] Impedir conflitos de horários.
- [x] Listar agendamentos.
- [x] Visualizar detalhes.
- [x] Cancelar agendamento.
- [x] Solicitar remarcação.
- [x] Alterar status do atendimento.

### 5. Área Administrativa

- [ ] Dashboard com dados reais e validação.
- [x] Endpoint para visualizar clientes.
- [x] Endpoint para consultar informações dos clientes.
- [x] Endpoint para visualizar agendamentos.
- [x] Endpoint para gerenciar agendamentos.
- [x] Gerenciar serviços.
- [x] Cadastrar serviços.
- [x] Editar serviços.
- [x] Ativar/desativar serviços.
- [x] Gerenciar valores.
- [x] Alterar status dos atendimentos.

### 6. Segurança e Tratamento de Erros

- [x] Utilizar prepared statements.
- [ ] Validar dados recebidos em todos os controllers.
- [x] Utilizar `password_hash()`.
- [x] Utilizar `password_verify()`.
- [x] Controlar acesso às áreas do sistema.
- [x] Implementar sessões.
- [x] Implementar logout.
- [ ] Revisar tratamento de erros em todo o sistema.
- [ ] Padronizar respostas JSON em todos os endpoints.
- [ ] Revisar códigos HTTP em todos os controllers.
- [ ] Avaliar e configurar CORS conforme o ambiente de hospedagem.
- [ ] Verificar proteção contra CSRF nas operações autenticadas por sessão.
- [ ] Revisar índices e restrições do banco de dados.

## Integração com o Frontend

A integração com o frontend será realizada gradualmente.

Inicialmente, o frontend utiliza dados simulados presentes em:

`frontend/assets/js/data/mock-data.js`

Durante a integração, os dados simulados serão substituídos gradualmente por informações reais provenientes do PHP e MySQL.

A substituição será realizada por módulos, evitando alterações desnecessárias em todo o frontend de uma única vez.

### Fluxo planejado

```text
Frontend
    ↓
JavaScript
    ↓
fetch()
    ↓
PHP
    ↓
MySQL
    ↓
Resposta JSON
    ↓
Atualização da interface
```

## Status do Projeto

**Etapa 05 — Backend: Em desenvolvimento.**

### Situação atual

- Conexão PHP → MySQL: configurada e testada.
- Banco de dados: criado.
- Estrutura inicial do backend: criada.
- Arquitetura MVC: implementada.
- Frontend: desenvolvido.
- JavaScript: desenvolvido.
- Dados simulados: funcionando.
- Comunicação JavaScript → PHP: implementada e testada.
- Autenticação e gerenciamento de usuários: implementados.
- Gerenciamento de serviços: implementado.
- Gerenciamento de agendamentos: implementado.
- Integração completa entre frontend e backend: em andamento.
- Testes gerais de integração e segurança: pendentes.

### Próximas etapas

1. Finalizar a revisão dos models e controllers.
2. Conferir a compatibilidade entre PHP e estrutura do banco de dados.
3. Integrar os módulos do frontend com os endpoints reais.
4. Substituir gradualmente os dados simulados.
5. Realizar testes de funcionamento e segurança.
6. Corrigir possíveis inconsistências encontradas durante a integração.