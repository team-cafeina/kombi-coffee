<?php
/**
 * TEMPLATE INICIAL — PERSONALIZE ESTE ARQUIVO.
 *
 * Esta tela existe apenas para validar que PHP + Apache/XAMPP
 * estão funcionando. Ela NÃO representa a interface final do projeto.
 */
$projectName = 'Nome da Aplicação';
$teamName = 'Nome da Equipe';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Projeto Integrador desenvolvido em PHP e MySQL.">
    <title><?= htmlspecialchars($projectName) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="#"><?= htmlspecialchars($projectName) ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Abrir navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#inicio">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projeto">Projeto</a></li>
                    <li class="nav-item"><a class="nav-link" href="pages/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section id="inicio" class="py-5">
            <div class="container py-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="badge text-bg-dark mb-3">Template inicial</span>
                        <h1 class="display-5 fw-bold">Seu ambiente PHP está funcionando.</h1>
                        <p class="lead text-body-secondary">
                            Agora substitua este conteúdo pela interface criada pela sua equipe no Figma.
                        </p>
                        <a class="btn btn-dark btn-lg" href="#projeto">Começar personalização</a>
                    </div>
                    <div class="col-lg-5">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="h5">Checklist inicial</h2>
                                <ul class="mb-0">
                                    <li>Alterar nome da aplicação;</li>
                                    <li>Aplicar logo e identidade visual;</li>
                                    <li>Atualizar README;</li>
                                    <li>Criar Issues;</li>
                                    <li>Desenvolver em branches.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="projeto" class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="h3">Projeto da equipe</h2>
                <p class="text-body-secondary mb-0">
                    Equipe atual: <strong><?= htmlspecialchars($teamName) ?></strong>. Edite este arquivo e transforme esta página na Home real do seu projeto.
                </p>
            </div>
        </section>
    </main>

    <footer class="border-top py-4">
        <div class="container small text-body-secondary">
            Projeto Integrador • PHP + MySQL • <?= date('Y') ?>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
