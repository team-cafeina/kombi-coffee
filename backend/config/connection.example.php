<?php
/**
 * EXEMPLO DIDÁTICO de conexão PDO.
 *
 * A equipe poderá evoluir esta implementação nas próximas atividades.
 */

$config = require __DIR__ . '/database.php';

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $config['host'],
    $config['port'],
    $config['database'],
    $config['charset']
);

try {
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $exception) {
    // Em produção, não exponha detalhes internos da exceção ao usuário.
    exit('Não foi possível conectar ao banco de dados.');
}
