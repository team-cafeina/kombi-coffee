<?php

/**
 * Cabeçalho comum das páginas públicas da loja.
 * Variáveis esperadas: $pageTitle (string) e $carrinho (Carrinho).
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
    <title><?= e($pageTitle ?? 'Loja') ?> — Kombi Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/loja.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark kc-navbar">
    <div class="container">
        <a class="navbar-brand kc-brand" href="../index.php">Kombi Coffee</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#lojaNav"
            aria-controls="lojaNav"
            aria-expanded="false"
            aria-label="Abrir navegação"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="lojaNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cardapio.php">Cardápio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php">
                        Sacola
                        <span class="badge text-bg-light"><?= $carrinho->quantidadeItens() ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Área da equipe</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-5">
    <div class="container">
