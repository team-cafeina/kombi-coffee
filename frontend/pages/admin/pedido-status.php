<?php

declare(strict_types=1);

/** Atualiza o status de um pedido (rota de POST do detalhe). */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('pedidos.php');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    flash('error', 'Token de segurança inválido. Tente novamente.');
    redirect('pedidos.php');
}

$pedidoId = (int) (filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT) ?: 0);
$status = trim((string) ($_POST['status'] ?? ''));

try {
    (new Pedido($pdo))->atualizarStatus($pedidoId, $status);
    flash('success', 'Status atualizado com sucesso.');
} catch (InvalidArgumentException $erro) {
    flash('error', $erro->getMessage());
}

redirect('pedido-detalhe.php?id=' . $pedidoId);
