<?php

declare(strict_types=1);

require_once __DIR__ . '/../../backend/config/bootstrap.php';

$auth = new Auth($pdo);
$auth->logout();

flash('success', 'Sessão encerrada com sucesso.');

redirect('login.php');
