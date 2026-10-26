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
$error = get_flash('error');

$pageTitle = 'Painel';
require __DIR__ . '/partials/header.php';
?>

<?php if ($success !== null): ?>
    <div class="alert alert-success" role="alert"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Painel administrativo</h1>
        <p class="text-body-secondary mb-0">Bem-vindo(a), <?= e($user['name']) ?>!</p>
    </div>
    <div class="d-flex gap-2">
        <a href="produtos.php" class="btn btn-success">Gerenciar produtos</a>
        <span class="badge text-bg-success align-self-center">Área protegida</span>
    </div>
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

<?php require __DIR__ . '/partials/footer.php'; ?>
