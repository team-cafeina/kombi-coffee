<?php

declare(strict_types=1);

/** Lista de pedidos no painel administrativo. */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');
$user = $auth->user();

$pedidos = (new Pedido($pdo))->listar();
$success = get_flash('success');
$error = get_flash('error');

$classes = [
    'recebido' => 'text-bg-primary',
    'em_preparo' => 'text-bg-warning',
    'pronto' => 'text-bg-info',
    'entregue' => 'text-bg-success',
    'cancelado' => 'text-bg-danger',
];

$pageTitle = 'Pedidos';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Pedidos</h1>
        <p class="text-body-secondary mb-0">Pedidos feitos pelo cardápio digital.</p>
    </div>
</div>

<?php if ($success !== null): ?>
    <div class="alert alert-success" role="alert"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Telefone</th>
                    <th>Data</th>
                    <th class="text-center">Itens</th>
                    <th class="text-end">Total</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pedidos === []): ?>
                    <tr>
                        <td colspan="8" class="text-center text-body-secondary py-4">
                            Nenhum pedido registrado ainda.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td class="fw-semibold">#<?= (int) $pedido['id'] ?></td>
                            <td><?= e($pedido['cliente']) ?></td>
                            <td><?= e($pedido['telefone']) ?></td>
                            <td class="small">
                                <?= date('d/m/Y H:i', strtotime((string) $pedido['created_at'])) ?>
                            </td>
                            <td class="text-center"><?= (int) $pedido['total_itens'] ?></td>
                            <td class="text-end">
                                R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <span class="badge <?= $classes[$pedido['status']] ?? 'text-bg-secondary' ?>">
                                    <?= e(Pedido::STATUS[$pedido['status']] ?? $pedido['status']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a
                                    href="pedido-detalhe.php?id=<?= (int) $pedido['id'] ?>"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
