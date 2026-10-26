<?php

/**
 * Cabeçalho comum das páginas da área administrativa.
 *
 * Variáveis esperadas antes do include:
 * - $pageTitle (string)
 * - $user (array) — usuário autenticado
 */

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Painel') ?> — Kombi Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">
                KOMBI COFFEE <span class="fw-normal small opacity-75">| Painel</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <a class="nav-link text-white-50 small d-none d-md-inline" href="produtos.php">Produtos</a>
                <span class="navbar-text small"><?= e($user['name']) ?> (<?= e($user['role']) ?>)</span>
                <a class="btn btn-outline-light btn-sm" href="../logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
