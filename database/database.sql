CREATE DATABASE IF NOT EXISTS estetica_dg93;

USE estetica_dg93;

CREATE TABLE IF NOT EXISTS
    usuarios (
        id_user INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        cpf VARCHAR(15) NOT NULL UNIQUE,
        sexo VARCHAR(13),
        perfil VARCHAR(10) NOT NULL,
        PRIMARY KEY (id_user)
    );

CREATE TABLE IF NOT EXISTS
    servicos (
        id_service INT NOT NULL AUTO_INCREMENT,
        nome_servico VARCHAR(50) NOT NULL,
        preco DECIMAL(10, 2) NOT NULL,
        ativo BOOLEAN NOT NULL,
        categoria VARCHAR(50) NOT NULL,

        PRIMARY KEY (id_service)
    );

CREATE TABLE IF NOT EXISTS
    agendamento (
        id_agendamento INT NOT NULL AUTO_INCREMENT,
        id_user INT NOT NULL ,
        id_service INT NOT NULL ,
        status VARCHAR(30) NOT NULL,
        data DATE NOT NULL,
        hora TIME NOT NULL,
        local VARCHAR(150) NOT NULL,

        PRIMARY KEY(id_agendamento),
        FOREIGN KEY (id_user)
            REFERENCES usuarios(id_user),
        FOREIGN KEY (id_service)
            REFERENCES servicos(id_service)
        
    );


    INSERT INTO usuarios (nome, email, senha, cpf, sexo, perfil) VALUES
    ('Guilherme', 'teste@gmail.com', '123456', '123.456.789-00', 'Masculino', 'admin');