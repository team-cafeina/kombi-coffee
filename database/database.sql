-- ==========================================================
-- KOMBI COFFEE — BANCO DE DADOS
-- Projeto Integrador — Sistemas para Internet (Senac)
-- MySQL / phpMyAdmin / XAMPP
-- ==========================================================
-- Este arquivo cria a estrutura do banco e insere dados
-- iniciais de teste (categorias, produtos, clientes e usuários).
--
-- Como usar:
--   1. Abra o phpMyAdmin.
--   2. Importe este arquivo (Import > Choose File > Go).
--   3. O banco "kombi_coffee" será criado automaticamente.
--
-- Observação: se o banco já existir com a estrutura antiga,
-- apague o banco "kombi_coffee" e importe este arquivo de novo.
-- ==========================================================

CREATE DATABASE IF NOT EXISTS kombi_coffee
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE kombi_coffee;

-- ==========================================================
-- USUÁRIOS DO SISTEMA (funcionários e administradores)
-- Autenticação com password_hash() / password_verify().
-- role: 'admin' (acesso total) ou 'funcionario' (painel).
-- ==========================================================

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'funcionario',
    aceitou_termos TINYINT(1) NOT NULL DEFAULT 0,
    termos_aceitos_em DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
-- CATEGORIAS DO CARDÁPIO
-- Ex.: Cafés, Bebidas Frias, Salgados, Doces.
-- ==========================================================

CREATE TABLE IF NOT EXISTS categorias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
-- PRODUTOS DO CARDÁPIO
-- Relacionamento: categorias (1) ---- (N) produtos
-- status: disponivel, indisponivel ou esgotado.
-- ==========================================================

CREATE TABLE IF NOT EXISTS produtos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT UNSIGNED NOT NULL,
    sku VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT,
    preco_venda DECIMAL(10,2) NOT NULL,
    preco_custo DECIMAL(10,2) NOT NULL DEFAULT 0,
    estoque INT UNSIGNED NOT NULL DEFAULT 0,
    estoque_minimo INT UNSIGNED NOT NULL DEFAULT 5,
    status ENUM('disponivel', 'indisponivel', 'esgotado') NOT NULL DEFAULT 'disponivel',
    imagem VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_produtos_categoria
        FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ==========================================================
-- CLIENTES
-- Dados usados para contato e entrega dos pedidos.
-- ==========================================================

CREATE TABLE IF NOT EXISTS clientes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) UNIQUE,
    telefone VARCHAR(20),
    endereco VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================================================
-- PEDIDOS
-- Relacionamento: clientes (1) ---- (N) pedidos
-- status: recebido, em_preparo, pronto, entregue ou cancelado.
-- ==========================================================

CREATE TABLE IF NOT EXISTS pedidos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT UNSIGNED NOT NULL,
    status ENUM('recebido', 'em_preparo', 'pronto', 'entregue', 'cancelado')
        NOT NULL DEFAULT 'recebido',
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    observacoes TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedidos_cliente
        FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ==========================================================
-- ITENS DO PEDIDO
-- Relacionamento: pedidos (1) ---- (N) pedidos_itens
--                 produtos (1) ---- (N) pedidos_itens
-- Guarda o preço do momento da venda (histórico).
-- ==========================================================

CREATE TABLE IF NOT EXISTS pedidos_itens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT UNSIGNED NOT NULL,
    produto_id INT UNSIGNED NOT NULL,
    quantidade INT UNSIGNED NOT NULL DEFAULT 1,
    preco_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_itens_pedido
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_itens_produto
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ==========================================================
-- DADOS INICIAIS DE TESTE
-- Os INSERTs usam ON DUPLICATE KEY UPDATE para poderem ser
-- executados novamente sem duplicar registros.
--
-- Credenciais de teste (senhas geradas com password_hash()):
--   Administrador -> admin@kombicoffee.com / admin123
--   Funcionário   -> funcionario@kombicoffee.com / func123
-- ==========================================================

INSERT INTO users (name, email, password_hash, role, aceitou_termos, termos_aceitos_em)
VALUES
    (
        'Administrador',
        'admin@kombicoffee.com',
        '$2y$10$xOP.t9X6SVb7AuhsVYoDp.FZA95csfynCehcYNaZZQFYZQmxJjOOO',
        'admin',
        1,
        NOW()
    ),
    (
        'Funcionário',
        'funcionario@kombicoffee.com',
        '$2y$10$QutG/UFh0AvEW73/1JKzKOwM4Y/1WGZ9yapWSVj/KDm23PRBPiE4C',
        'funcionario',
        1,
        NOW()
    )
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    password_hash = VALUES(password_hash),
    role = VALUES(role);

INSERT INTO categorias (nome)
VALUES
    ('Cafés'),
    ('Bebidas Frias'),
    ('Salgados'),
    ('Doces')
ON DUPLICATE KEY UPDATE nome = VALUES(nome);

INSERT INTO produtos (categoria_id, sku, nome, descricao, preco_venda, preco_custo, estoque, estoque_minimo, status)
VALUES
    (
        (SELECT id FROM categorias WHERE nome = 'Cafés'),
        'CAF-001',
        'Café Espresso',
        'Café espresso encorpado, servido em xícara de 30 ml.',
        6.00,
        2.00,
        100,
        10,
        'disponivel'
    ),
    (
        (SELECT id FROM categorias WHERE nome = 'Cafés'),
        'CAF-002',
        'Cappuccino',
        'Café espresso com leite vaporizado e espuma cremosa.',
        9.50,
        3.50,
        80,
        10,
        'disponivel'
    ),
    (
        (SELECT id FROM categorias WHERE nome = 'Bebidas Frias'),
        'BEB-001',
        'Cold Brew',
        'Café extraído a frio por 12 horas, servido com gelo.',
        12.00,
        5.00,
        30,
        5,
        'disponivel'
    ),
    (
        (SELECT id FROM categorias WHERE nome = 'Salgados'),
        'SAL-001',
        'Pão de Queijo',
        'Pão de queijo artesanal, assado na hora.',
        7.00,
        3.00,
        0,
        10,
        'esgotado'
    ),
    (
        (SELECT id FROM categorias WHERE nome = 'Doces'),
        'DOC-001',
        'Brownie',
        'Brownie de chocolate meio amargo com castanhas.',
        8.50,
        3.20,
        12,
        5,
        'disponivel'
    ),
    (
        (SELECT id FROM categorias WHERE nome = 'Doces'),
        'DOC-002',
        'Bolo de Cenoura',
        'Fatia de bolo de cenoura com cobertura de chocolate.',
        9.00,
        3.50,
        8,
        5,
        'indisponivel'
    )
ON DUPLICATE KEY UPDATE
    categoria_id = VALUES(categoria_id),
    nome = VALUES(nome),
    descricao = VALUES(descricao),
    preco_venda = VALUES(preco_venda),
    preco_custo = VALUES(preco_custo),
    estoque = VALUES(estoque),
    estoque_minimo = VALUES(estoque_minimo),
    status = VALUES(status);

INSERT INTO clientes (nome, email, telefone, endereco)
VALUES
    ('Maria Silva', 'maria.silva@email.com', '(11) 99999-0001', 'Rua das Flores, 123'),
    ('João Souza', 'joao.souza@email.com', '(11) 98888-0002', 'Avenida Paulista, 456'),
    ('Ana Lima', 'ana.lima@email.com', '(11) 97777-0003', 'Rua do Sol, 789')
ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    telefone = VALUES(telefone),
    endereco = VALUES(endereco);
