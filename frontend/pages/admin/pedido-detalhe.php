<?php

declare(strict_types=1);

/** Detalhe de um pedido e alteração de status. */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

$pedidoId = (int) (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0);
$pedidoModel = new Pedido($pdo);
$pedido = $pedidoModel->find($pedidoId);

if ($pedido === null) {
    flash('error', 'Pedido não encontrado.');
    redirect('pedidos.php');
}

$itens = $pedidoModel->itens($pedidoId);
$success = get_flash('success');
$error = get_flash('error');

$pageTitle = 'Pedido #' . $pedidoId;
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Pedido #<?= (int) $pedido['id'] ?></h1>
        <p class="text-body-secondary mb-0">
            Feito em <?= date('d/m/Y H:i', strtotime((string) $pedido['created_at'])) ?>
        </p>
    </div>
    <a href="pedidos.php" class="btn btn-outline-secondary">← Todos os pedidos</a>
</div>

<?php if ($success !== null): ?>
    <div class="alert alert-success" role="alert"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <span class="fw-semibold">Itens do pedido</span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>SKU</th>
                            <th class="text-center">Qtd.</th>
                            <th class="text-end">Preço unitário</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td><?= e($item['produto']) ?></td>
                                <td><code><?= e($item['sku']) ?></code></td>
                                <td class="text-center"><?= (int) $item['quantidade'] ?></td>
                                <td class="text-end">
                                    R$ <?= number_format((float) $item['preco_unitario'], 2, ',', '.') ?>
                                </td>
                                <td class="text-end">
                                    R$ <?= number_format((float) $item['preco_unitario'] * (int) $item['quantidade'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end">
                                R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 mb-3">Cliente</h2>
                <p class="mb-1"><strong><?= e($pedido['cliente']) ?></strong></p>
                <?php if (trim((string) $pedido['telefone']) !== ''): ?>
                    <p class="mb-1 small">Telefone: <?= e($pedido['telefone']) ?></p>
                <?php endif; ?>
                <?php if (trim((string) $pedido['email']) !== ''): ?>
                    <p class="mb-1 small">E-mail: <?= e($pedido['email']) ?></p>
                <?php endif; ?>
                <?php if (trim((string) $pedido['endereco']) !== ''): ?>
                    <p class="mb-1 small">Endereço: <?= e($pedido['endereco']) ?></p>
                <?php endif; ?>
                <?php if (trim((string) $pedido['observacoes']) !== ''): ?>
                    <p class="small text-body-secondary mt-3 mb-0">
                        <strong>Observações:</strong> <?= e($pedido['observacoes']) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Status do pedido</h2>
                <form method="post" action="pedido-status.php">
                    <input type="hidden" name="pedido_id" value="<?= (int) $pedido['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                    <select name="status" class="form-select mb-3">
                        <?php foreach (Pedido::STATUS as $valor => $rotulo): ?>
                            <option
                                value="<?= e($valor) ?>"
                                <?= $pedido['status'] === $valor ? 'selected' : '' ?>
                            >
                                <?= e($rotulo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-success w-100">Atualizar status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
