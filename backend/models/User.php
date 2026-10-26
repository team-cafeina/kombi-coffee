<?php

declare(strict_types=1);

/**
 * Model da tabela `users`.
 *
 * Responsável por consultar e atualizar as contas de acesso
 * (administradores e funcionários) usadas na autenticação.
 */
final class User
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Busca um usuário pelo e-mail.
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, password_hash, role, aceitou_termos, termos_aceitos_em
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /**
     * Registra o aceite dos termos de uso no primeiro login.
     */
    public function markTermsAccepted(int $userId): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users
             SET aceitou_termos = 1, termos_aceitos_em = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $stmt->execute(['id' => $userId]);
    }

    /**
     * Atualiza o hash da senha (usado quando o algoritmo precisa ser revalidado).
     */
    public function updatePasswordHash(int $userId, string $hash): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users
             SET password_hash = :hash
             WHERE id = :id'
        );
        $stmt->execute([
            'hash' => $hash,
            'id' => $userId,
        ]);
    }
}
