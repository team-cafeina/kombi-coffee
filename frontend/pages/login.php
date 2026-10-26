<?php

declare(strict_types=1);

require_once __DIR__ . '/../../backend/config/bootstrap.php';

$auth = new Auth($pdo);

if ($auth->check()) {
    redirect('admin/index.php');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = null;
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $token = (string) ($_POST['csrf_token'] ?? '');

    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $error = 'Sessão expirada. Recarregue a página e tente novamente.';
    } elseif ($email === '' || $password === '') {
        $error = 'Informe e-mail e senha.';
    } elseif (!$auth->attempt($email, $password)) {
        $error = 'E-mail ou senha inválidos.';
    } else {
        flash('success', 'Bem-vindo(a), ' . $auth->user()['name'] . '!');
        redirect('admin/index.php');
    }
}

$success = get_flash('success');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Kombi Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.login-page {
            min-height: 100vh;
            background: #f6f1e3;
        }

        .login-card {
            max-width: 900px;
            border: 0;
            border-radius: 1rem;
            overflow: hidden;
        }

        .login-brand {
            background: linear-gradient(160deg, #3d4a1f 0%, #6b7a3a 100%);
            color: #fdf8e7;
        }

        .btn-brand {
            background: #b23b2e;
            border-color: #b23b2e;
            color: #fff;
        }

        .btn-brand:hover,
        .btn-brand:focus {
            background: #932f24;
            border-color: #932f24;
            color: #fff;
        }
    </style>
</head>
<body class="login-page">
    <main class="container py-5">
        <div class="card login-card shadow-lg mx-auto">
            <div class="row g-0">
                <div class="col-md-5 login-brand d-none d-md-flex flex-column justify-content-between p-4 p-lg-5">
                    <div>
                        <span class="badge rounded-pill text-bg-light mb-3">KOMBI COFFEE</span>
                        <h1 class="h3 fw-bold">Seja bem-vindo!</h1>
                        <p class="mb-0 opacity-75">Acesse o painel de gestão da cafeteria.</p>
                    </div>
                    <p class="small mb-0 opacity-75">Cafés especiais, atendimento com carinho.</p>
                </div>

                <div class="col-md-7 p-4 p-lg-5">
                    <h2 class="h4 mb-1">Entrar</h2>
                    <p class="text-body-secondary mb-4">Use sua conta de funcionário.</p>

                    <?php if ($success !== null): ?>
                        <div class="alert alert-success" role="alert"><?= e($success) ?></div>
                    <?php endif; ?>

                    <?php if ($error !== null): ?>
                        <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
                    <?php endif; ?>

                    <form method="post" action="login.php">
                        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= e($email) ?>"
                                autocomplete="username"
                                autofocus
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Senha</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-brand w-100">Entrar</button>
                    </form>

                    <div class="d-flex justify-content-between mt-4 small">
                        <a href="../index.php" class="link-secondary">← Página inicial</a>
                        <span class="text-body-secondary">Esqueceu a senha? Fale com a gerência.</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
