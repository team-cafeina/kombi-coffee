<?php

declare(strict_types=1);

/**
 * Ponto de entrada do back-end.
 *
 * Inicia a sessão, carrega a conexão com o banco e as classes do projeto.
 * Todas as páginas PHP devem incluir este arquivo antes de usar o banco:
 *
 *     require_once __DIR__ . '/../../backend/config/bootstrap.php';
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!is_file(__DIR__ . '/connection.php')) {
    exit(
        'Conexão não configurada. Copie backend/config/connection.example.php ' .
        'para backend/config/connection.php e ajuste as credenciais.'
    );
}

if (!is_file(__DIR__ . '/database.php')) {
    exit(
        'Configuração do banco não encontrada. Copie backend/config/database.example.php ' .
        'para backend/config/database.php e informe os dados do MySQL.'
    );
}

require_once __DIR__ . '/connection.php'; // disponibiliza $pdo

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../services/Auth.php';

/**
 * Escapa texto para exibição segura em HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Redireciona para outra página e encerra a execução.
 */
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

/**
 * Guarda uma mensagem de flash na sessão (ex.: "Produto cadastrado com sucesso").
 */
function flash(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}

/**
 * Lê e remove uma mensagem de flash da sessão.
 */
function get_flash(string $type): ?string
{
    if (!isset($_SESSION['flash'][$type])) {
        return null;
    }

    $message = $_SESSION['flash'][$type];
    unset($_SESSION['flash'][$type]);

    return $message;
}
