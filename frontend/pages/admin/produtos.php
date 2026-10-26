<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

$user = $auth->user();
$produtoModel = new Produto($pdo);
$produtos = $produtoModel->all();
$success = get_flash('success');
$error = get_flash('error');

$statusLabels = [
    'disponivel' => 'Disponível',
    'indisponivel' => 'Indisponível',
    'esgotado' => 'Esgotado',
];

$statusClasses = [
    'disponivel' => 'text-bg-success',
    'indisponivel' => 'text-bg-secondary',
    'esgotado' => 'text-bg-danger',
];

$pageTitle = 'Produtos';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Produtos</h1>
        <p class="text-body-secondary mb-0">Gerencie o cardápio da Kombi Coffee.</p>
    </div>
    <a href="produto-form.php" class="btn btn-success">+ Novo produto</a>
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
                    <th>Produto</th>
                    <th>SKU</th>
                    <th>Categoria</th>
                    <th class="text-end">Preço</th>
                    <th class="text-center">Estoque</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($produtos === []): ?>
                    <tr>
                        <td colspan="7" class="text-center text-body-secondary py-4">
                            Nenhum produto cadastrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($produto['nome']) ?></td>
                            <td><code><?= e($produto['sku']) ?></code></td>
                            <td><?= e($produto['categoria']) ?></td>
                            <td class="text-end">
                                R$ <?= number_format((float) $produto['preco_venda'], 2, ',', '.') ?>
                            </td>
                            <td class="text-center"><?= (int) $produto['estoque'] ?></td>
                            <td>
                                <span class="badge <?= $statusClasses[$produto['status']] ?? 'text-bg-secondary' ?>">
                                    <?= e($statusLabels[$produto['status']] ?? $produto['status']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a
                                    href="produto-form.php?id=<?= (int) $produto['id'] ?>"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Editar
                                </a>

                                <form
                                    method="post"
                                    action="produto-excluir.php"
                                    class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este produto?');"
                                >
                                    <input type="hidden" name="id" value="<?= (int) $produto['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
