<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

$user = $auth->user();
$produtoModel = new Produto($pdo);
$produtos = $produtoModel->all();
$categorias = $produtoModel->categorias();
$estoqueBaixo = $produtoModel->lowStock();
$success = get_flash('success');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel — Kombi Coffee</title>
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
                <span class="navbar-text small"><?= e($user['name']) ?> (<?= e($user['role']) ?>)</span>
                <a class="btn btn-outline-light btn-sm" href="../logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if ($success !== null): ?>
            <div class="alert alert-success" role="alert"><?= e($success) ?></div>
        <?php endif; ?>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h1 class="h3 mb-1">Painel administrativo</h1>
                <p class="text-body-secondary mb-0">Bem-vindo(a), <?= e($user['name']) ?>!</p>
            </div>
            <span class="badge text-bg-success">Área protegida</span>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-body-secondary text-uppercase small mb-1">Produtos</p>
                        <p class="display-6 mb-0"><?= count($produtos) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-body-secondary text-uppercase small mb-1">Categorias</p>
                        <p class="display-6 mb-0"><?= count($categorias) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-body-secondary text-uppercase small mb-1">Estoque baixo</p>
                        <p class="display-6 mb-0 text-danger"><?= count($estoqueBaixo) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Produtos com estoque baixo</span>
                <span class="badge text-bg-warning"><?= count($estoqueBaixo) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Estoque</th>
                            <th>Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($estoqueBaixo === []): ?>
                            <tr>
                                <td colspan="3" class="text-center text-body-secondary py-4">
                                    Nenhum produto com estoque baixo.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($estoqueBaixo as $produto): ?>
                                <tr>
                                    <td><?= e($produto['nome']) ?></td>
                                    <td><?= (int) $produto['estoque'] ?></td>
                                    <td><?= (int) $produto['estoque_minimo'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="text-body-secondary small mt-3 mb-0">
            CRUD de produtos e demais módulos chegam nas próximas fases.
        </p>
    </main>
</body>
</html>
