# Backend — Estética DG93

## Objetivo

Desenvolver o backend do sistema utilizando PHP e MySQL, realizando a comunicação entre o frontend, o servidor e o banco de dados.

O backend será responsável pelo processamento das requisições, manipulação dos dados, autenticação dos usuários, gerenciamento dos serviços e controle dos agendamentos.

## Arquitetura

O sistema utiliza a seguinte estrutura de comunicação:

HTML + CSS + JavaScript
        ↓
     fetch()
        ↓
       JSON
        ↓
       PHP
        ↓
      MySQL

As respostas do backend serão retornadas em JSON para serem interpretadas pelo JavaScript.

### Fluxo de comunicação

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
MySQL
    ↓
PHP
    ↓
JSON
    ↓
JavaScript
    ↓
HTML

## Estrutura do Backend

backend/
├── config/
│   └── connection.php
├── controllers/
├── models/
└── services/

Config: responsável pelas configurações e conexão com o banco.
Controllers: responsáveis por receber e processar as requisições do frontend.
Models: responsáveis pela representação e manipulação dos dados do sistema.
Services: responsáveis pelas regras e operações específicas da aplicação.

# Comunicação Frontend → Backend

O JavaScript realizará requisições ao PHP utilizando `fetch()`.

Os dados enviados pelo frontend serão organizados no formato JSON.

O PHP receberá os dados utilizando `json_decode()`.

Após o processamento, o PHP retornará as informações utilizando `json_encode()`.

### Fluxo

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
MySQL
    ↓
PHP
    ↓
JSON
    ↓
JavaScript

# Banco de Dados

O backend utilizará o banco de dados:

estetica_dg93

A conexão com o banco de dados será realizada através do arquivo:

backend/config/connection.php

A estrutura do banco está documentada em:

docs/BANCO_DE_DADOS.md

### Principais tabelas

    - usuarios
    - servicos
    - agendamento

# Etapas do Desenvolvimento

## 1. Comunicação entre JavaScript e PHP

- [x] Criar primeiro endpoint PHP
- [x] Enviar dados pelo JavaScript
- [x] Enviar dados em JSON
- [x] Receber JSON no PHP
- [x] Processar a requisição
- [x] Retornar resposta em JSON
- [x] Interpretar resposta no JavaScript
- [x] Testar comunicação

### Teste realizado

Foi realizado um teste de comunicação entre JavaScript e PHP utilizando `fetch()` e JSON.

O JavaScript enviou dados em JSON para o PHP. O PHP recebeu os dados utilizando `json_decode()`, processou a informação e retornou uma resposta utilizando `json_encode()`. O JavaScript recebeu e interpretou a resposta utilizando `response.json()`.

## 2. Usuários

- [x] Cadastro de cliente
- [x] Login
- [x] Logout
- [x] Autenticação
- [x] Controle de acesso
- [x] Separação entre cliente e administrador
- [x] Perfil do usuário
- [x] Hash de senha

## 3. Serviços

- [x] Listar serviços
- [x] Consultar valores
- [x] Cadastrar serviço
- [ ] Editar serviço
- [ ] Alterar valores
- [ ] Ativar serviço
- [ ] Desativar serviço

## 4. Agendamentos

- [x] Criar agendamento
- [x] Selecionar serviço
- [x] Selecionar data
- [x] Selecionar horário
- [x] Verificar disponibilidade
- [x] Impedir conflitos de horários
- [x] Listar agendamentos
- [x] Visualizar detalhes
- [x] Cancelar agendamento
- [ ] Solicitar remarcação
- [ ] Alterar status do atendimento

## 5. Área Administrativa

- [ ] Dashboard com dados reais
- [ ] Visualizar clientes
- [ ] Consultar informações dos clientes
- [ ] Gerenciar serviços
- [ ] Cadastrar serviços
- [ ] Editar serviços
- [ ] Ativar/desativar serviços
- [ ] Gerenciar valores
- [ ] Visualizar agendamentos
- [ ] Gerenciar agendamentos
- [ ] Alterar status dos atendimentos

## 6. Segurança e Tratamento de Erros

- [ ] Utilizar prepared statements
- [ ] Validar dados recebidos
- [ ] Utilizar `password_hash()`
- [ ] Utilizar `password_verify()`
- [ ] Controlar acesso às áreas do sistema
- [ ] Implementar sessões
- [ ] Implementar logout
- [ ] Implementar tratamento de erros
- [ ] Padronizar respostas JSON
- [ ] Definir códigos HTTP apropriados
- [ ] Avaliar necessidade de configuração de CORS

# Integração com o Frontend

A integração com o frontend será realizada gradualmente.

Inicialmente, o frontend continuará utilizando os dados simulados presentes em:

frontend/assets/js/data/mock-data.js

Durante a integração com o backend, os dados simulados serão substituídos gradualmente por dados reais provenientes do PHP e MySQL.

A substituição será realizada por módulos, evitando a alteração de todo o frontend de uma única vez.

### Fluxo planejado

mock-data.js
     ↓
JavaScript
     ↓
PHP
     ↓
MySQL

# Status

**Etapa 05 — Backend:** Em desenvolvimento.

### Situação atual

- Conexão PHP → MySQL: configurada e testada
- Banco de dados: criado
- Estrutura inicial do backend: criada
- Frontend: desenvolvido
- JavaScript: desenvolvido
- Dados simulados: funcionando
- Comunicação JavaScript → PHP: próxima etapa
- Integração completa com MySQL: pendente