# Banco de Dados

## Banco

ESTETICA_DG93

## Tabela USUARIOS

- id_user (PK)
- nome
- email
- senha
- cpf (UNIQUE)
- sexo
- perfil

## Tabela SERVICOS

- id_service (PK)
- nome_servico
- preco
- ativo
- categoria

## Tabela AGENDAMENTO

- id_agendamento (PK)
- id_user (FK)
- id_service (FK)
- status
- data
- hora
- local

## Relacionamentos

USUARIOS 1 ───── N AGENDAMENTO

SERVICOS 1 ───── N AGENDAMENTO