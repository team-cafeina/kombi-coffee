<?php

declare(strict_types=1);

/** Sacola do cliente (carrinho na sessão). */

require_once __DIR__ . '/../../backend/config/bootstrap.php';

$carrinho = new Carrinho();
$produtoModel = new Produto($pdo);

$itens = [];
$total = 0.0;

foreach ($carrinho->itens() as $produtoId => $quantidade) {
    $produto = $produtoModel->find($produtoId);

    if ($produto === null || $produto['status'] !== 'disponivel') {
        continue;
    }

    $preco = (float) $produto['preco_venda'];
    $itens[] = [
        'id' => $produtoId,
        'nome' => $produto['nome'],
        'preco' => $preco,
        'quantidade' => $quantidade,
        'subtotal' => $preco * $quantidade,
    ];
    $total += $preco * $quantidade;
}

$pageTitle = 'Sacola';
$avisoErro = get_flash('error');
$avisoSucesso = get_flash('success');

require __DIR__ . '/partials/loja-inicio.php';
?>

<h1 class="h3 mb-1">Sua sacola</h1>
<p class="text-body-secondary mb-4">Confira os itens antes de finalizar o pedido.</p>

<?php if ($avisoSucesso !== null): ?>
    <div class="alert alert-success" role="alert"><?= e($avisoSucesso) ?></div>
<?php endif; ?>

<?php if ($avisoErro !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($avisoErro) ?></div>
<?php endif; ?>

<?php if ($itens === []): ?>
    <div class="kc-vazio">
        <p class="mb-2 fw-semibold">Sua sacola está vazia.</p>
        <a href="cardapio.php" class="btn btn-success">Ver o cardápio</a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="list-group">
                <?php foreach ($itens as $item): ?>
                    <div class="list-group-item d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h2 class="h6 mb-1"><?= e($item['nome']) ?></h2>
                            <span class="text-body-secondary small">
                                R$ <?= number_format($item['preco'], 2, ',', '.') ?> cada
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <form method="post" action="carrinho-item.php">
                                <input type="hidden" name="produto_id" value="<?= (int) $item['id'] ?>">
                                <input type="hidden" name="acao" value="diminuir">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary" aria-label="Diminuir">−</button>
                            </form>

                            <span class="fw-semibold"><?= (int) $item['quantidade'] ?></span>

                            <form method="post" action="carrinho-item.php">
                                <input type="hidden" name="produto_id" value="<?= (int) $item['id'] ?>">
                                <input type="hidden" name="acao" value="adicionar">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary" aria-label="Aumentar">+</button>
                            </form>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <span class="kc-preco">
                                R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                            </span>
                            <form method="post" action="carrinho-item.php">
                                <input type="hidden" name="produto_id" value="<?= (int) $item['id'] ?>">
                                <input type="hidden" name="acao" value="remover">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="cardapio.php" class="btn btn-outline-secondary mt-3">← Continuar comprando</a>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Resumo</h2>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-body-secondary">Itens</span>
                        <span><?= $carrinho->quantidadeItens() ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-semibold">Total</span>
                        <span class="kc-preco">R$ <?= number_format($total, 2, ',', '.') ?></span>
                    </div>
                    <a href="checkout.php" class="btn btn-success w-100">Finalizar pedido</a>
                    <p class="small text-body-secondary mb-0 mt-3">
                        Você não precisa criar conta. Só informe seu nome e telefone no próximo passo.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/loja-fim.php'; ?>
