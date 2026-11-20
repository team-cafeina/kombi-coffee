<?php

declare(strict_types=1);

/** Confirmação exibida depois que o pedido foi gravado. */

require_once __DIR__ . '/../../backend/config/bootstrap.php';

$pedidoId = (int) ($_SESSION['ultimo_pedido'] ?? 0);

if ($pedidoId <= 0) {
    redirect('cardapio.php');
}

unset($_SESSION['ultimo_pedido']);

$pedidoModel = new Pedido($pdo);
$pedido = $pedidoModel->find($pedidoId);

if ($pedido === null) {
    redirect('cardapio.php');
}

$itens = $pedidoModel->itens($pedidoId);
$pageTitle = 'Pedido confirmado';

require __DIR__ . '/partials/loja-inicio.php';
?>

<div class="text-center mb-4">
    <div class="mx-auto mb-3 kc-vazio" style="width: 90px; height: 90px; padding: 18px;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="width:100%;height:100%;color:var(--kc-green)">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
    </div>
    <h1 class="h3 mb-1">Pedido enviado!</h1>
    <p class="text-body-secondary mb-2">
        Obrigado, <?= e($pedido['cliente']) ?>. Seu pedido foi registrado.
    </p>
    <p class="mb-0">
        <strong>Número do pedido:</strong>
        <span class="badge text-bg-success fs-6">#<?= (int) $pedido['id'] ?></span>
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Resumo</h2>

                <?php foreach ($itens as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            <?= (int) $item['quantidade'] ?>× <?= e($item['produto']) ?>
                        </span>
                        <span>
                            R$ <?= number_format((float) $item['preco_unitario'] * (int) $item['quantidade'], 2, ',', '.') ?>
                        </span>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-between border-top pt-3 mt-3">
                    <span class="fw-semibold">Total</span>
                    <span class="kc-preco">
                        R$ <?= number_format((float) $pedido['total'], 2, ',', '.') ?>
                    </span>
                </div>

                <?php if (trim((string) $pedido['observacoes']) !== ''): ?>
                    <p class="small text-body-secondary mt-3 mb-0">
                        <strong>Observações:</strong> <?= e($pedido['observacoes']) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="cardapio.php" class="btn btn-success">Voltar ao cardápio</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/loja-fim.php'; ?>
