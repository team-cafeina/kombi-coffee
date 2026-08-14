-- ==========================================================
-- PROJETO INTEGRADOR — TEMPLATE DO BANCO DE DADOS
-- MySQL / phpMyAdmin / XAMPP
-- ==========================================================
-- IMPORTANTE:
-- Este arquivo é apenas um ponto de partida.
-- A equipe deverá substituir nomes, tabelas, campos e relacionamentos
-- de acordo com o projeto definido na Atividade 01.
-- ==========================================================

CREATE DATABASE IF NOT EXISTS projeto_integrador
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE projeto_integrador;

-- ==========================================================
-- EXEMPLO DE ENTIDADE PARA AUTENTICAÇÃO
-- A equipe poderá adaptar os campos conforme a necessidade.
-- Nunca armazene senha em texto puro.
-- Use password_hash() no PHP para gerar o valor de password_hash.
-- ==========================================================

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==========================================================
-- ATIVIDADE DA EQUIPE
-- Crie abaixo pelo menos duas entidades relacionadas.
-- Exemplo conceitual:
-- clientes (1) -------- (N) agendamentos
-- ==========================================================

-- CREATE TABLE ...
-- CREATE TABLE ...
-- ALTER TABLE ... ADD CONSTRAINT ... FOREIGN KEY ...
