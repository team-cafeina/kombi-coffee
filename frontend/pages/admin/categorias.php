<?php

declare(strict_types=1);

/** Listagem de categorias no painel administrativo. */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');
$user = $auth->user();

$categorias = (new Categoria($pdo))->all();
$success = get_flash('success');
$error = get_flash('error');

$pageTitle = 'Categorias';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Categorias</h1>
        <p class="text-body-secondary mb-0">Organize os produtos do cardápio.</p>
    </div>
    <a href="categoria-form.php" class="btn btn-success">+ Nova categoria</a>
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
                    <th>Categoria</th>
                    <th class="text-center">Produtos</th>
                    <th>Cadastrada em</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($categorias === []): ?>
                    <tr>
                        <td colspan="4" class="text-center text-body-secondary py-4">
                            Nenhuma categoria cadastrada.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($categoria['nome']) ?></td>
                            <td class="text-center">
                                <span class="badge text-bg-light"><?= (int) $categoria['total_produtos'] ?></span>
                            </td>
                            <td class="small text-body-secondary">
                                <?= date('d/m/Y', strtotime((string) $categoria['created_at'])) ?>
                            </td>
                            <td class="text-end">
                                <a
                                    href="categoria-form.php?id=<?= (int) $categoria['id'] ?>"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Editar
                                </a>

                                <form
                                    method="post"
                                    action="categoria-excluir.php"
                                    class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');"
                                >
                                    <input type="hidden" name="id" value="<?= (int) $categoria['id'] ?>">
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
