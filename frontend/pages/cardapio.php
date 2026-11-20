<?php

declare(strict_types=1);

/**
 * Cardápio público da Kombi Coffee.
 *
 * Página aberta (sem login) que lista os produtos disponíveis lidos do banco,
 * agrupados por categoria. As fotos vêm do campo `produtos.imagem`; quando o
 * produto não tem imagem cadastrada, é exibido um espaço reservado.
 *
 * Página separada do `frontend/index.php` de propósito: a home é da Melissa.
 * A lógica e o PHP ficam aqui; o visual pode ser ajustado no CSS deste arquivo.
 */

require_once __DIR__ . '/../../backend/config/bootstrap.php';

$produtoModel = new Produto($pdo);
$produtos = $produtoModel->disponiveis();

// Agrupa os produtos por categoria mantendo a ordem alfabética.
$categorias = [];
foreach ($produtos as $produto) {
    $categorias[$produto['categoria']][] = $produto;
}

/**
 * Converte o valor gravado em `produtos.imagem` em uma URL utilizável.
 *
 * Aceita URL completa (http/https) ou caminho relativo à pasta `frontend/`.
 */
function imagem_url(?string $caminho): ?string
{
    $caminho = trim((string) $caminho);

    if ($caminho === '') {
        return null;
    }

    if (preg_match('#^https?://#i', $caminho) === 1) {
        return $caminho;
    }

    return '../' . ltrim($caminho, '/');
}

$pageTitle = 'Cardápio';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cardápio da Kombi Coffee: cafés, bebidas frias, salgados e doces.">
    <title>Cardápio — Kombi Coffee</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --kc-green: #3d4a1f;
            --kc-green-soft: #6b7a3a;
            --kc-cream: #f6f1e3;
            --kc-red: #b23b2e;
            --kc-ink: #23241f;
        }

        body {
            color: var(--kc-ink);
            background-color: #fffdf8;
        }

        .kc-navbar {
            background-color: var(--kc-green);
        }

        .kc-brand {
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .kc-hero {
            background-color: var(--kc-cream);
            border-bottom: 4px solid var(--kc-green);
        }

        .kc-hero h1 {
            color: var(--kc-green);
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        .kc-section-title {
            color: var(--kc-green);
            font-weight: 700;
            font-size: 1.35rem;
            margin: 0 0 1rem;
            display: inline-block;
            border-bottom: 3px solid var(--kc-red);
            padding-bottom: .35rem;
        }

        .kc-card {
            border: 1px solid #e6e0cf;
            border-radius: .75rem;
            overflow: hidden;
            height: 100%;
            transition: transform .15s ease, box-shadow .15s ease;
            background-color: #fff;
        }

        .kc-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1.25rem rgba(61, 74, 31, .12);
        }

        .kc-foto {
            position: relative;
            aspect-ratio: 4 / 3;
            background: linear-gradient(135deg, #e8e4d2 0%, #d7d3bd 100%);
            overflow: hidden;
        }

        .kc-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .kc-foto-vazia {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--kc-green-soft);
            opacity: .55;
        }

        .kc-foto-vazia svg {
            width: 64px;
            height: 64px;
        }

        .kc-card .card-body {
            padding: 1rem 1.05rem 1.15rem;
        }

        .kc-preco {
            color: var(--kc-red);
            font-weight: 800;
            font-size: 1.15rem;
            white-space: nowrap;
        }

        .kc-descricao {
            color: #6f7066;
            font-size: .92rem;
        }

        .kc-vazio {
            background-color: var(--kc-cream);
            border-radius: .75rem;
            padding: 2.5rem 1.5rem;
            text-align: center;
            color: #6f7066;
        }

        .kc-footer {
            background-color: var(--kc-green);
            color: #e9e7db;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark kc-navbar">
    <div class="container">
        <a class="navbar-brand kc-brand" href="../index.php">Kombi Coffee</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#cardapioNav"
            aria-controls="cardapioNav"
            aria-expanded="false"
            aria-label="Abrir navegação"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="cardapioNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="cardapio.php">Cardápio</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Área da equipe</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="kc-hero py-5">
    <div class="container py-3">
        <h1 class="display-6 mb-2">Nosso cardápio</h1>
        <p class="lead text-body-secondary mb-0">
            Cafés especiais, bebidas geladas, salgados e doces feitos na hora.
        </p>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <?php if ($categorias === []): ?>
            <div class="kc-vazio">
                <p class="mb-1 fw-semibold">Nenhum produto disponível no momento.</p>
                <p class="mb-0 small">Volte em breve para conferir as novidades.</p>
            </div>
        <?php else: ?>
            <?php foreach ($categorias as $nomeCategoria => $itens): ?>
                <section class="mb-5">
                    <h2 class="kc-section-title"><?= e((string) $nomeCategoria) ?></h2>

                    <div class="row g-4">
                        <?php foreach ($itens as $produto): ?>
                            <?php $imagem = imagem_url($produto['imagem']); ?>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <article class="card kc-card d-flex flex-column">
                                    <div class="kc-foto">
                                        <?php if ($imagem !== null): ?>
                                            <img
                                                src="<?= e($imagem) ?>"
                                                alt="<?= e($produto['nome']) ?>"
                                                loading="lazy"
                                            >
                                        <?php else: ?>
                                            <div class="kc-foto-vazia" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 8h12v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8Z"/>
                                                    <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16"/>
                                                    <path d="M4 21h14"/>
                                                    <path d="M7.5 3.5c0 .8.8 1.2.8 2M11 3.5c0 .8.8 1.2.8 2"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                            <h3 class="h6 fw-bold mb-0"><?= e($produto['nome']) ?></h3>
                                            <span class="kc-preco">
                                                R$ <?= number_format((float) $produto['preco_venda'], 2, ',', '.') ?>
                                            </span>
                                        </div>

                                        <?php if (trim((string) $produto['descricao']) !== ''): ?>
                                            <p class="kc-descricao mb-0">
                                                <?= e($produto['descricao']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<footer class="kc-footer py-4">
    <div class="container d-flex flex-wrap justify-content-between gap-2 small">
        <span>Kombi Coffee • cardápio atualizado pela equipe</span>
        <span>Projeto Integrador • PHP + MySQL</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
