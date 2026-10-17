DROP DATABASE estetica_dg93;

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

-- ==========================================
-- 10 USUÁRIOS DE TESTE
-- ==========================================

INSERT INTO usuarios
(nome, email, senha, cpf, sexo, perfil)
VALUES
('Guilherme Admin', 'admin@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '555.666.777-88', 'Masculino', 'admin'),
('Cliente 01', 'cliente01@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '111.222.333-44', 'Masculino', 'cliente'),
('Cliente 02', 'cliente02@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '222.333.444-55', 'Feminino', 'cliente'),
('Cliente 03', 'cliente03@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '333.444.555-66', 'Masculino', 'cliente'),
('Cliente 04', 'cliente04@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '444.555.666-77', 'Feminino', 'cliente'),
('Cliente 05', 'cliente05@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '666.777.888-99', 'Masculino', 'cliente'),
('Cliente 06', 'cliente06@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '777.888.999-00', 'Feminino', 'cliente'),
('Cliente 07', 'cliente07@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '888.999.000-11', 'Masculino', 'cliente'),
('Cliente 08', 'cliente08@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '999.000.111-22', 'Feminino', 'cliente'),
('Cliente 09', 'cliente09@teste.com', '$2y$12$Kfv4NBe0Z4p4geg..NJ9QuCj248SGjKdajzftDHF3W32e4C8r2g4.', '000.111.222-33', 'Masculino', 'cliente');


-- ==========================================
-- 10 SERVIÇOS DE TESTE
-- ==========================================

INSERT INTO servicos
(nome_servico, preco, ativo, categoria)
VALUES
('Lavagem Completa', 90.00, 1, 'Lavagem'),
('Higienização Interna', 220.00, 1, 'Higienização'),
('Polimento', 350.00, 1, 'Estética'),
('Enceramento', 150.00, 1, 'Estética'),
('Higienização de Estofados', 180.00, 1, 'Estofados'),
('Lavagem de Moto', 60.00, 0, 'Motocicleta'),
('Lavagem Simples', 50.00, 1, 'Lavagem'),
('Cristalização de Pintura', 280.00, 1, 'Estética'),
('Limpeza de Motor', 120.00, 1, 'Limpeza'),
('Revitalização de Plásticos', 100.00, 1, 'Estética');


-- ==========================================
-- 10 AGENDAMENTOS DE TESTE
-- ==========================================


INSERT INTO agendamento
(id_user, id_service, status, data, hora, local)
VALUES
(2, 1, 'AGUARDANDO_CONFIRMACAO', '2026-10-20', '09:00:00', 'Estética DG93'),
(3, 2, 'APROVADO',               '2026-10-20', '10:00:00', 'Estética DG93'),
(4, 3, 'EM_ANDAMENTO',           '2026-10-20', '11:00:00', 'Estética DG93'),
(5, 4, 'CONCLUIDO',              '2026-10-20', '12:00:00', 'Estética DG93'),
(6, 5, 'CANCELADO',              '2026-10-20', '13:00:00', 'Estética DG93'),
(7, 6, 'NEGADO',                 '2026-10-21', '09:00:00', 'Estética DG93'),
(8, 7, 'AGUARDANDO_CONFIRMACAO', '2026-10-21', '10:00:00', 'Estética DG93'),
(9, 8, 'APROVADO',               '2026-10-21', '11:00:00', 'Estética DG93'),
(10, 9, 'EM_ANDAMENTO',          '2026-10-21', '14:00:00', 'Estética DG93'),
(2, 10, 'CONCLUIDO',              '2026-10-21', '15:00:00', 'Estética DG93');


