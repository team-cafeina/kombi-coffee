<?php

declare(strict_types=1);

/** Adiciona um produto à sacola do cardápio. */

require_once __DIR__ . '/../../backend/config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('cardapio.php');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    flash('error', 'Token de segurança inválido. Tente novamente.');
    redirect('cardapio.php');
}

$produtoId = (int) (filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT) ?: 0);
$quantidade = (int) (filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT) ?: 0);

$produto = (new Produto($pdo))->find($produtoId);

if ($produto === null || $produto['status'] !== 'disponivel') {
    flash('error', 'Produto indisponível.');
    redirect('cardapio.php');
}

if ($quantidade <= 0) {
    flash('error', 'Informe uma quantidade válida.');
    redirect('cardapio.php');
}

$carrinho = new Carrinho();
$jaAdicionado = $carrinho->itens()[$produtoId] ?? 0;

if ($jaAdicionado + $quantidade > (int) $produto['estoque']) {
    flash('error', 'Não há estoque suficiente para essa quantidade.');
    redirect('cardapio.php');
}

$carrinho->adicionar($produtoId, $quantidade);
flash('success', $produto['nome'] . ' adicionado à sacola.');

redirect('cardapio.php');
