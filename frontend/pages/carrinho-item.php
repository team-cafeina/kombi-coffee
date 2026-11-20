<?php

declare(strict_types=1);

/** Altera a quantidade ou remove um item da sacola. */

require_once __DIR__ . '/../../backend/config/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('carrinho.php');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    flash('error', 'Token de segurança inválido. Tente novamente.');
    redirect('carrinho.php');
}

$produtoId = (int) (filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT) ?: 0);
$acao = trim((string) ($_POST['acao'] ?? ''));

$carrinho = new Carrinho();

if ($acao === 'remover') {
    $carrinho->remover($produtoId);
    flash('success', 'Item removido da sacola.');
} elseif ($acao === 'diminuir') {
    $carrinho->diminuir($produtoId, 1);
} elseif ($acao === 'adicionar') {
    $produto = (new Produto($pdo))->find($produtoId);
    $atual = $carrinho->itens()[$produtoId] ?? 0;

    if ($produto !== null && $atual < (int) $produto['estoque']) {
        $carrinho->adicionar($produtoId, 1);
    } else {
        flash('error', 'Não há mais unidades disponíveis em estoque.');
    }
}

redirect('carrinho.php');
