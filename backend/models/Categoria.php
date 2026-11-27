<?php

declare(strict_types=1);

/**
 * Model da tabela `categorias`.
 */
final class Categoria
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Lista as categorias com a quantidade de produtos de cada uma.
     */
    public function all(): array
    {
        $sql = 'SELECT c.id, c.nome, c.created_at,
                       (SELECT COUNT(*) FROM produtos p
                        WHERE p.categoria_id = c.id) AS total_produtos
                FROM categorias c
                ORDER BY c.nome';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome FROM categorias WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $categoria = $stmt->fetch();

        return $categoria ?: null;
    }

    public function create(string $nome): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO categorias (nome) VALUES (:nome)');
        $stmt->execute(['nome' => $nome]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, string $nome): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE categorias SET nome = :nome WHERE id = :id'
        );

        return $stmt->execute(['nome' => $nome, 'id' => $id]);
    }

    /**
     * Exclui uma categoria. Retorna false se ainda houver produtos nela.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM produtos WHERE categoria_id = :id'
        );
        $stmt->execute(['id' => $id]);

        if ((int) $stmt->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->pdo->prepare('DELETE FROM categorias WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
