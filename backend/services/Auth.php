<?php

declare(strict_types=1);

/**
 * Serviço de autenticação.
 *
 * Usa password_verify() para conferir a senha, cria a sessão do usuário,
 * registra o aceite dos termos no primeiro login e protege páginas.
 */
final class Auth
{
    private User $users;

    public function __construct(private PDO $pdo)
    {
        $this->users = new User($pdo);
    }

    /**
     * Tenta autenticar um usuário pelo e-mail e senha.
     */
    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        // Se o algoritmo do hash mudou, gera um novo hash com a senha informada.
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $this->users->updatePasswordHash(
                (int) $user['id'],
                password_hash($password, PASSWORD_DEFAULT)
            );
        }

        // Primeiro login: registra o aceite dos termos de uso.
        if (!(bool) $user['aceitou_termos']) {
            $this->users->markTermsAccepted((int) $user['id']);
        }

        if (!headers_sent()) {
            session_regenerate_id(true);
        }

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        return true;
    }

    /**
     * Indica se existe um usuário autenticado.
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Retorna os dados do usuário autenticado (ou null).
     */
    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Encerra a sessão do usuário.
     */
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies') && !headers_sent()) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    /**
     * Exige usuário autenticado; caso contrário, redireciona para o login.
     *
     * @param string $loginPath Caminho relativo até a página de login.
     */
    public function requireLogin(string $loginPath): void
    {
        if ($this->check()) {
            return;
        }

        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? null;

        redirect($loginPath);
    }
}
