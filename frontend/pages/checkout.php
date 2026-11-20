<?php

declare(strict_types=1);

/**
 * Checkout do cardápio digital.
 *
 * O cliente NÃO faz login: informa apenas nome e telefone para identificar
 * o pedido. Tudo é gravado em uma transação (cliente, pedido, itens e baixa
 * de estoque).
 */

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

    if ($quantidade > (int) $produto['estoque']) {
        flash('error', 'Sem estoque suficiente para ' . $produto['nome'] . '.');
        redirect('carrinho.php');
    }

    $preco = (float) $produto['preco_venda'];
    $itens[] = [
        'id' => $produtoId,
        'nome' => $produto['nome'],
        'preco' => $preco,
        'quantidade' => $quantidade,
    ];
    $total += $preco * $quantidade;
}

if ($itens === []) {
    redirect('carrinho.php');
}

$form = [
    'nome' => '',
    'telefone' => '',
    'email' => '',
    'endereco' => '',
    'observacoes' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf_token'] ?? '');
    if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        flash('error', 'Token de segurança inválido. Tente novamente.');
        redirect('checkout.php');
    }

    foreach (array_keys($form) as $campo) {
        $form[$campo] = trim((string) ($_POST[$campo] ?? ''));
    }

    $telefone = preg_replace('/\D+/', '', $form['telefone']) ?? '';

    if ($form['nome'] === '' || $telefone === '') {
        flash('error', 'Informe seu nome e um telefone válido.');
        redirect('checkout.php');
    }

    try {
        $clienteModel = new Cliente($pdo);
        $clienteId = $clienteModel->obterOuCriar(
            $form['nome'],
            $form['email'],
            $telefone,
            $form['endereco']
        );

        $pedidoModel = new Pedido($pdo);
        $movimentos = new MovimentoEstoque($pdo);
        $pedidoId = $pedidoModel->criar(
            $clienteId,
            $itens,
            $form['observacoes'],
            $movimentos
        );

        $carrinho->limpar();
        $_SESSION['ultimo_pedido'] = $pedidoId;

        redirect('pedido-confirmado.php');
    } catch (Throwable $erro) {
        flash('error', 'Não foi possível finalizar o pedido: ' . $erro->getMessage());
        redirect('checkout.php');
    }
}

$pageTitle = 'Finalizar pedido';
$avisoErro = get_flash('error');

require __DIR__ . '/partials/loja-inicio.php';
?>

<h1 class="h3 mb-1">Finalizar pedido</h1>
<p class="text-body-secondary mb-4">Só falta informar seus dados — sem login, sem senha.</p>

<?php if ($avisoErro !== null): ?>
    <div class="alert alert-danger" role="alert"><?= e($avisoErro) ?></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Seus dados</h2>

                <form method="post" action="checkout.php">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="nome"
                                name="nome"
                                value="<?= e($form['nome']) ?>"
                                placeholder="Seu nome"
                                required
                            >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="telefone" class="form-label">Telefone / WhatsApp <span class="text-danger">*</span></label>
                            <input
                                type="tel"
                                class="form-control"
                                id="telefone"
                                name="telefone"
                                value="<?= e($form['telefone']) ?>"
                                placeholder="(11) 99999-9999"
                                required
                            >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">E-mail <span class="text-body-secondary small">(opcional)</span></label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= e($form['email']) ?>"
                                placeholder="voce@email.com"
                            >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="endereco" class="form-label">Endereço <span class="text-body-secondary small">(opcional)</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="endereco"
                                name="endereco"
                                value="<?= e($form['endereco']) ?>"
                                placeholder="Rua, número, bairro"
                            >
                        </div>
                        <div class="col-12">
                            <label for="observacoes" class="form-label">Observações <span class="text-body-secondary small">(opcional)</span></label>
                            <textarea
                                class="form-control"
                                id="observacoes"
                                name="observacoes"
                                rows="3"
                                placeholder="Ex.: sem açúcar, troco para R$ 50..."
                            ><?= e($form['observacoes']) ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">Enviar pedido</button>
                        <a href="carrinho.php" class="btn btn-outline-secondary">Voltar à sacola</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Resumo do pedido</h2>

                <ul class="list-unstyled mb-3">
                    <?php foreach ($itens as $item): ?>
                        <li class="d-flex justify-content-between mb-2">
                            <span><?= (int) $item['quantidade'] ?>× <?= e($item['nome']) ?></span>
                            <span>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="d-flex justify-content-between border-top pt-3">
                    <span class="fw-semibold">Total</span>
                    <span class="kc-preco">R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/loja-fim.php'; ?>
