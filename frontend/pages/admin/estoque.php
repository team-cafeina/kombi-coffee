<?php

declare(strict_types=1);

/**
 * Controle de estoque (área administrativa).
 *
 * Exibe os indicadores, permite registrar entradas e saídas e mostra o
 * histórico de movimentações. Referência visual: tela "Controle de Estoque"
 * do protótipo do Figma.
 */

require_once __DIR__ . '/../../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->requireLogin('../login.php');
$user = $auth->user();

$produtoModel = new Produto($pdo);
$movimentoModel = new MovimentoEstoque($pdo);

$categorias = $produtoModel->categorias();
$categoriaId = (int) (filter_input(INPUT_GET, 'categoria', FILTER_VALIDATE_INT) ?: 0);

$produtos = $produtoModel->all();
if ($categoriaId > 0) {
    $produtos = array_values(array_filter(
        $produtos,
        static fn (array $produto): bool => (int) $produto['categoria_id'] === $categoriaId
    ));
}

$totais = $movimentoModel->totais();
$quantidadeBaixo = count($produtoModel->lowStock());
$movimentacoes = $movimentoModel->recentes(10);

$success = get_flash('success');
$error = get_flash('error');

$pageTitle = 'Estoque';
require __DIR__ . '/partials/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 mb-1">Controle de Estoque</h1>
        <p class="text-body-secondary mb-0">Registre entradas, saídas e acompanhe os níveis mínimos.</p>
    </div>
    <a href="produtos.php" class="btn btn-outline-secondary">Gerenciar produtos</a>
</div>

<?php if ($success !== null): ?>
    <div class="alert alert-success" role="alert"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-body-secondary text-uppercase small mb-1">Total de itens</p>
                <p class="display-6 mb-0"><?= (int) $totais['produtos'] ?></p>
                <p class="small text-body-secondary mb-0"><?= (int) $totais['unidades'] ?> unidades em estoque</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-body-secondary text-uppercase small mb-1">Valor de venda total</p>
                <p class="display-6 mb-0 text-success">
                    R$ <?= number_format($totais['valor_venda'], 2, ',', '.') ?>
                </p>
                <p class="small text-body-secondary mb-0">Somatório do estoque pelo preço de venda</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <p class="text-body-secondary text-uppercase small mb-1">Itens com nível baixo</p>
                <p class="display-6 mb-0 text-danger"><?= $quantidadeBaixo ?></p>
                <p class="small text-body-secondary mb-0">Estoque igual ou abaixo do mínimo</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span class="fw-semibold">Produtos</span>

        <form method="get" action="estoque.php" class="d-flex flex-wrap gap-2">
            <select name="categoria" class="form-select form-select-sm" aria-label="Filtrar por categoria">
                <option value="0">Todas as categorias</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option
                        value="<?= (int) $categoria['id'] ?>"
                        <?= $categoriaId === (int) $categoria['id'] ? 'selected' : '' ?>
                    >
                        <?= e($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-sm btn-success">Filtrar</button>
            <?php if ($categoriaId > 0): ?>
                <a href="estoque.php" class="btn btn-sm btn-outline-secondary">Limpar</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>SKU</th>
                    <th>Categoria</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-center">Mínimo</th>
                    <th>Status</th>
                    <th style="min-width: 270px;">Movimentação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($produtos === []): ?>
                    <tr>
                        <td colspan="7" class="text-center text-body-secondary py-4">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <?php $estoqueBaixo = (int) $produto['estoque'] <= (int) $produto['estoque_minimo']; ?>
                        <tr>
                            <td class="fw-semibold"><?= e($produto['nome']) ?></td>
                            <td><code><?= e($produto['sku']) ?></code></td>
                            <td><?= e($produto['categoria']) ?></td>
                            <td class="text-center fw-semibold"><?= (int) $produto['estoque'] ?></td>
                            <td class="text-center"><?= (int) $produto['estoque_minimo'] ?></td>
                            <td>
                                <?php if ($estoqueBaixo): ?>
                                    <span class="badge text-bg-warning">Estoque baixo</span>
                                <?php else: ?>
                                    <span class="badge text-bg-success">Normal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <form method="post" action="estoque-movimentar.php" class="d-flex gap-1">
                                        <input type="hidden" name="produto_id" value="<?= (int) $produto['id'] ?>">
                                        <input type="hidden" name="tipo" value="entrada">
                                        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                        <input
                                            type="number"
                                            name="quantidade"
                                            min="1"
                                            value="1"
                                            class="form-control form-control-sm"
                                            style="width: 68px;"
                                            aria-label="Quantidade de entrada"
                                            required
                                        >
                                        <button type="submit" class="btn btn-sm btn-outline-success">+ Entrada</button>
                                    </form>

                                    <form method="post" action="estoque-movimentar.php" class="d-flex gap-1">
                                        <input type="hidden" name="produto_id" value="<?= (int) $produto['id'] ?>">
                                        <input type="hidden" name="tipo" value="saida">
                                        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                        <input
                                            type="number"
                                            name="quantidade"
                                            min="1"
                                            max="<?= (int) $produto['estoque'] ?>"
                                            value="1"
                                            class="form-control form-control-sm"
                                            style="width: 68px;"
                                            aria-label="Quantidade de saída"
                                            required
                                        >
                                        <button type="submit" class="btn btn-sm btn-outline-danger">- Saída</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($movimentacoes !== []): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <span class="fw-semibold">Últimas movimentações</span>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th class="text-center">Qtd.</th>
                        <th>Usuário</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimentacoes as $movimentacao): ?>
                        <tr>
                            <td class="small">
                                <?= date('d/m/Y H:i', strtotime((string) $movimentacao['created_at'])) ?>
                            </td>
                            <td><?= e($movimentacao['produto']) ?></td>
                            <td>
                                <?php if ($movimentacao['tipo'] === 'entrada'): ?>
                                    <span class="badge text-bg-success">Entrada</span>
                                <?php else: ?>
                                    <span class="badge text-bg-danger">Saída</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= (int) $movimentacao['quantidade'] ?></td>
                            <td class="small"><?= e($movimentacao['usuario']) ?></td>
                            <td class="small text-body-secondary">
                                <?= e($movimentacao['observacao']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
