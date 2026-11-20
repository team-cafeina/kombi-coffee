<?php

declare(strict_types=1);

/**
 * Processa uma movimentação de estoque (entrada ou saída).
 *
 * Rota de POST usada pelo formulário de admin/estoque.php.
 */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('estoque.php');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    flash('error', 'Token de segurança inválido. Tente novamente.');
    redirect('estoque.php');
}

$produtoId = (int) (filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT) ?: 0);
$tipo = trim((string) ($_POST['tipo'] ?? ''));
$quantidade = (int) (filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT) ?: 0);
$observacao = trim((string) ($_POST['observacao'] ?? ''));

$movimentoModel = new MovimentoEstoque($pdo);
$usuario = $auth->user();

try {
    $movimentoModel->registrar(
        $produtoId,
        (int) $usuario['id'],
        $tipo,
        $quantidade,
        $observacao !== '' ? $observacao : null
    );

    $palavra = $tipo === 'entrada' ? 'Entrada' : 'Saída';
    flash('success', $palavra . ' de ' . $quantidade . ' unidade(s) registrada com sucesso.');
} catch (InvalidArgumentException | RuntimeException $erro) {
    flash('error', $erro->getMessage());
}

redirect('estoque.php');
