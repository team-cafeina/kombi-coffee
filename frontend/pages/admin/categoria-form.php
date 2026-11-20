<?php

declare(strict_types=1);

/** Cadastro e edição de categoria. */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

$categoriaModel = new Categoria($pdo);

$id = (int) (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0);
$categoria = null;

if ($id > 0) {
    $categoria = $categoriaModel->find($id);

    if ($categoria === null) {
        flash('error', 'Categoria não encontrada.');
        redirect('categorias.php');
    }
}

$nome = (string) ($categoria['nome'] ?? '');
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf_token'] ?? '');
    $nome = trim((string) ($_POST['nome'] ?? ''));

    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $erros[] = 'Sessão expirada. Recarregue a página e tente novamente.';
    }

    if ($nome === '') {
        $erros[] = 'Informe o nome da categoria.';
    }

    if (mb_strlen($nome) > 60) {
        $erros[] = 'O nome deve ter no máximo 60 caracteres.';
    }

    if ($erros === []) {
        try {
            if ($id > 0) {
                $categoriaModel->update($id, $nome);
                flash('success', 'Categoria atualizada com sucesso.');
            } else {
                $categoriaModel->create($nome);
                flash('success', 'Categoria cadastrada com sucesso.');
            }

            redirect('categorias.php');
        } catch (PDOException $erro) {
            $erros[] = 'Já existe uma categoria com esse nome.';
        }
    }
}

$pageTitle = $id > 0 ? 'Editar categoria' : 'Nova categoria';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1"><?= $id > 0 ? 'Editar categoria' : 'Nova categoria' ?></h1>
        <p class="text-body-secondary mb-0">Ex.: Cafés, Bebidas Frias, Salgados, Doces.</p>
    </div>
    <a href="categorias.php" class="btn btn-outline-secondary">Voltar</a>
</div>

<?php if ($erros !== []): ?>
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            <?php foreach ($erros as $erro): ?>
                <li><?= e($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="post" action="categoria-form.php<?= $id > 0 ? '?id=' . $id : '' ?>">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome da categoria</label>
                <input
                    type="text"
                    class="form-control"
                    id="nome"
                    name="nome"
                    value="<?= e($nome) ?>"
                    maxlength="60"
                    placeholder="Ex.: Bolos e tortas"
                    required
                >
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="categorias.php" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
