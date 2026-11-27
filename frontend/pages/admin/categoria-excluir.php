<?php

declare(strict_types=1);

/** Exclusão de categoria (rota de POST da listagem). */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('categorias.php');
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    flash('error', 'Token de segurança inválido. Tente novamente.');
    redirect('categorias.php');
}

$id = (int) (filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0);

if ((new Categoria($pdo))->delete($id)) {
    flash('success', 'Categoria excluída com sucesso.');
} else {
    flash('error', 'Não é possível excluir: existem produtos vinculados a esta categoria.');
}

redirect('categorias.php');
