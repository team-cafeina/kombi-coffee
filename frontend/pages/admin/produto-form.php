<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');

$user = $auth->user();
$produtoModel = new Produto($pdo);
$categorias = $produtoModel->categorias();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$produto = null;

if ($id > 0) {
    $produto = $produtoModel->find($id);

    if ($produto === null) {
        flash('error', 'Produto não encontrado.');
        redirect('produtos.php');
    }
}

$erros = [];

$form = [
    'nome' => (string) ($produto['nome'] ?? ''),
    'sku' => (string) ($produto['sku'] ?? ''),
    'categoria_id' => (string) ($produto['categoria_id'] ?? ''),
    'descricao' => (string) ($produto['descricao'] ?? ''),
    'preco_venda' => $produto !== null
        ? number_format((float) $produto['preco_venda'], 2, ',', '')
        : '',
    'preco_custo' => $produto !== null
        ? number_format((float) $produto['preco_custo'], 2, ',', '')
        : '',
    'estoque' => (string) ($produto['estoque'] ?? '0'),
    'estoque_minimo' => (string) ($produto['estoque_minimo'] ?? '5'),
    'status' => (string) ($produto['status'] ?? 'disponivel'),
    'imagem' => (string) ($produto['imagem'] ?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['nome'] = trim((string) ($_POST['nome'] ?? ''));
    $form['sku'] = strtoupper(trim((string) ($_POST['sku'] ?? '')));
    $form['categoria_id'] = trim((string) ($_POST['categoria_id'] ?? ''));
    $form['descricao'] = trim((string) ($_POST['descricao'] ?? ''));
    $form['preco_venda'] = trim((string) ($_POST['preco_venda'] ?? ''));
    $form['preco_custo'] = trim((string) ($_POST['preco_custo'] ?? ''));
    $form['estoque'] = trim((string) ($_POST['estoque'] ?? ''));
    $form['estoque_minimo'] = trim((string) ($_POST['estoque_minimo'] ?? ''));
    $form['status'] = trim((string) ($_POST['status'] ?? ''));
    $form['imagem'] = trim((string) ($_POST['imagem'] ?? ''));

    $token = (string) ($_POST['csrf_token'] ?? '');

    $categoriaId = filter_var($form['categoria_id'], FILTER_VALIDATE_INT);
    $precoVenda = filter_var(str_replace(',', '.', $form['preco_venda']), FILTER_VALIDATE_FLOAT);
    $precoCusto = filter_var(str_replace(',', '.', $form['preco_custo']), FILTER_VALIDATE_FLOAT);
    $estoque = filter_var($form['estoque'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $estoqueMinimo = filter_var($form['estoque_minimo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $erros[] = 'Sessão expirada. Recarregue a página e tente novamente.';
    }

    if ($form['nome'] === '') {
        $erros[] = 'Informe o nome do produto.';
    }

    if ($form['sku'] === '') {
        $erros[] = 'Informe o SKU do produto.';
    }

    $categoriaIds = array_map(
        static fn (array $categoria): int => (int) $categoria['id'],
        $categorias
    );

    if ($categoriaId === false || !in_array((int) $categoriaId, $categoriaIds, true)) {
        $erros[] = 'Selecione uma categoria válida.';
    }

    if ($precoVenda === false || $precoVenda < 0) {
        $erros[] = 'Informe um preço de venda válido.';
    }

    if ($precoCusto === false || $precoCusto < 0) {
        $erros[] = 'Informe um preço de custo válido.';
    }

    if ($estoque === false) {
        $erros[] = 'Informe um estoque válido (número inteiro maior ou igual a zero).';
    }

    if ($estoqueMinimo === false) {
        $erros[] = 'Informe um estoque mínimo válido (número inteiro maior ou igual a zero).';
    }

    $statusPermitidos = ['disponivel', 'indisponivel', 'esgotado'];

    if (!in_array($form['status'], $statusPermitidos, true)) {
        $erros[] = 'Selecione um status válido.';
    }

    if ($form['sku'] !== '') {
        $existente = $produtoModel->findBySku($form['sku']);

        if ($existente !== null && (int) $existente['id'] !== $id) {
            $erros[] = 'Já existe um produto com esse SKU.';
        }
    }

    if ($erros === []) {
        $dados = [
            'categoria_id' => (int) $categoriaId,
            'sku' => $form['sku'],
            'nome' => $form['nome'],
            'descricao' => $form['descricao'] !== '' ? $form['descricao'] : null,
            'preco_venda' => (float) $precoVenda,
            'preco_custo' => (float) $precoCusto,
            'estoque' => (int) $estoque,
            'estoque_minimo' => (int) $estoqueMinimo,
            'status' => $form['status'],
            'imagem' => $form['imagem'] !== '' ? $form['imagem'] : null,
        ];

        try {
            if ($id > 0) {
                $produtoModel->update($id, $dados);
                flash('success', 'Produto atualizado com sucesso.');
            } else {
                $produtoModel->create($dados);
                flash('success', 'Produto cadastrado com sucesso.');
            }

            redirect('produtos.php');
        } catch (PDOException $exception) {
            $erros[] = 'Não foi possível salvar o produto. Verifique se o SKU já existe.';
        }
    }
}

$pageTitle = $id > 0 ? 'Editar produto' : 'Novo produto';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1"><?= $id > 0 ? 'Editar produto' : 'Novo produto' ?></h1>
        <p class="text-body-secondary mb-0">
            <?= $id > 0 ? 'Atualize os dados do produto.' : 'Cadastre um novo item no cardápio.' ?>
        </p>
    </div>
    <a href="produtos.php" class="btn btn-outline-secondary">Voltar</a>
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
        <form method="post" action="produto-form.php<?= $id > 0 ? '?id=' . $id : '' ?>">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

            <div class="row g-3">
                <div class="col-md-8">
                    <label for="nome" class="form-label">Nome do produto</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="<?= e($form['nome']) ?>"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label for="sku" class="form-label">SKU</label>
                    <input
                        type="text"
                        class="form-control"
                        id="sku"
                        name="sku"
                        value="<?= e($form['sku']) ?>"
                        placeholder="Ex.: CAF-003"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option
                                value="<?= (int) $categoria['id'] ?>"
                                <?= (string) $categoria['id'] === (string) $form['categoria_id'] ? 'selected' : '' ?>
                            >
                                <?= e($categoria['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="preco_venda" class="form-label">Preço de venda (R$)</label>
                    <input
                        type="text"
                        inputmode="decimal"
                        class="form-control"
                        id="preco_venda"
                        name="preco_venda"
                        value="<?= e($form['preco_venda']) ?>"
                        placeholder="0,00"
                        required
                    >
                </div>

                <div class="col-md-3">
                    <label for="preco_custo" class="form-label">Preço de custo (R$)</label>
                    <input
                        type="text"
                        inputmode="decimal"
                        class="form-control"
                        id="preco_custo"
                        name="preco_custo"
                        value="<?= e($form['preco_custo']) ?>"
                        placeholder="0,00"
                    >
                </div>

                <div class="col-md-3">
                    <label for="estoque" class="form-label">Estoque</label>
                    <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="estoque"
                        name="estoque"
                        value="<?= e($form['estoque']) ?>"
                        required
                    >
                </div>

                <div class="col-md-3">
                    <label for="estoque_minimo" class="form-label">Estoque mínimo</label>
                    <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="estoque_minimo"
                        name="estoque_minimo"
                        value="<?= e($form['estoque_minimo']) ?>"
                        required
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="disponivel" <?= $form['status'] === 'disponivel' ? 'selected' : '' ?>>
                            Disponível
                        </option>
                        <option value="indisponivel" <?= $form['status'] === 'indisponivel' ? 'selected' : '' ?>>
                            Indisponível
                        </option>
                        <option value="esgotado" <?= $form['status'] === 'esgotado' ? 'selected' : '' ?>>
                            Esgotado
                        </option>
                    </select>
                </div>

                <div class="col-md-9">
                    <label for="imagem" class="form-label">Imagem (URL ou caminho)</label>
                    <input
                        type="text"
                        class="form-control"
                        id="imagem"
                        name="imagem"
                        value="<?= e($form['imagem']) ?>"
                        placeholder="assets/images/produto.jpg"
                    >
                </div>

                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= e($form['descricao']) ?></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="produtos.php" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
