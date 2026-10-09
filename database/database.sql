CREATE DATABASE IF NOT EXISTS estetica_dg93;

USE estetica_dg93;

CREATE TABLE IF NOT EXISTS usuarios (
    id_user INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(15) NOT NULL UNIQUE,
    sexo VARCHAR(13),
    perfil VARCHAR(10) NOT NULL,
    PRIMARY KEY (id_user)
);

CREATE TABLE IF NOT EXISTS servicos (
    id_service INT NOT NULL AUTO_INCREMENT,
    nome_servico VARCHAR(50) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    ativo BOOLEAN NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_service)
);

CREATE TABLE IF NOT EXISTS agendamento (
    id_agendamento INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_service INT NOT NULL,
    status VARCHAR(30) NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    local VARCHAR(150) NOT NULL,
    PRIMARY KEY (id_agendamento),
    FOREIGN KEY (id_user) REFERENCES usuarios(id_user),
    FOREIGN KEY (id_service) REFERENCES servicos(id_service)
);

-- USUÁRIOS DE TESTE

INSERT INTO usuarios
(nome, email, senha, cpf, sexo, perfil)
VALUES
(
    'Guilherme',
    'admin@teste.com',
    '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.',
    '123.456.789-00',
    'Masculino',
    'admin'
),
(
    'Cliente Teste',
    'cliente@teste.com',
    '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.',
    '111.222.333-44',
    'Masculino',
    'cliente'
);


-- SERVIÇOS DE TESTE


INSERT INTO servicos
(nome_servico, preco, ativo, categoria)
VALUES
('Lavagem Completa', 90.00, 1, 'Lavagem'),
('Higienização Interna', 220.00, 1, 'Higienização'),
('Polimento', 350.00, 1, 'Estética'),
('Enceramento', 150.00, 1, 'Estética'),
('Higienização de Estofados', 180.00, 1, 'Estofados'),
('Lavagem de Moto', 60.00, 0, 'Motocicleta');


-- AGENDAMENTOS DE TESTE


INSERT INTO agendamento
(id_user, id_service, status, data, hora, local)
VALUES
(2, 1, 'AGUARDANDO_CONFIRMACAO', '2026-10-10', '14:00:00', 'Estética DG93'),
(2, 2, 'APROVADO', '2026-10-11', '10:00:00', 'Estética DG93'),
(2, 3, 'EM_ANDAMENTO', '2026-10-12', '15:00:00', 'Estética DG93'),
(2, 4, 'CONCLUIDO', '2026-10-13', '09:00:00', 'Estética DG93'),
(2, 5, 'CANCELADO', '2026-10-14', '16:00:00', 'Estética DG93');



-- CONSULTA PARA TESTE

SELECT
    agendamento.id_agendamento,
    usuarios.nome,
    servicos.nome_servico,
    servicos.preco,
    agendamento.status,
    agendamento.data,
    agendamento.hora,
    agendamento.local
FROM agendamento
JOIN usuarios
    ON agendamento.id_user = usuarios.id_user
JOIN servicos
    ON agendamento.id_service = servicos.id_service;


-- CONSULTA QUANTIDADES PARA DASHBOARD
    
    -- Total de clientes
SELECT COUNT(*)
FROM usuarios
WHERE perfil = 'cliente';

    -- Serviços ativos
SELECT COUNT(*)
FROM servicos
WHERE ativo = 1;

    -- Total de agendamentos
SELECT COUNT(*)
FROM agendamento;

SELECT COUNT(*)
FROM agendamento
WHERE status = 'AGUARDANDO_CONFIRMACAO';

SELECT COUNT(*)
FROM agendamento
WHERE status = 'APROVADO';

SELECT COUNT(*)
FROM agendamento
WHERE status = 'EM_ANDAMENTO';

SELECT COUNT(*)
FROM agendamento
WHERE status = 'CONCLUIDO';

SELECT COUNT(*)
FROM agendamento
WHERE status = 'NEGADO';

SELECT COUNT(*)
FROM agendamento
WHERE status = 'CANCELADO';

-- Cliente

SELECT COUNT(*) as total_agendamentos
FROM agendamento
WHERE agendamento.id_user = :id_user;