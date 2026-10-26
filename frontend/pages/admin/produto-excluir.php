<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('produtos.php');
}

$sessionToken = (string) ($_SESSION['csrf_token'] ?? '');
$token = (string) ($_POST['csrf_token'] ?? '');
$id = (int) ($_POST['id'] ?? 0);

if ($sessionToken === '' || !hash_equals($sessionToken, $token)) {
    flash('error', 'Sessão expirada. Tente novamente.');
    redirect('produtos.php');
}

if ($id <= 0) {
    flash('error', 'Produto inválido.');
    redirect('produtos.php');
}

$produtoModel = new Produto($pdo);

if ($produtoModel->find($id) === null) {
    flash('error', 'Produto não encontrado.');
    redirect('produtos.php');
}

try {
    $produtoModel->delete($id);
    flash('success', 'Produto excluído com sucesso.');
} catch (PDOException $exception) {
    flash('error', 'Não foi possível excluir: o produto está vinculado a um pedido.');
}

redirect('produtos.php');
