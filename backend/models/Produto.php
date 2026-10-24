<?php

declare(strict_types=1);

/**
 * Model da tabela `produtos`.
 *
 * Concentra as consultas e o CRUD base de produtos, além de
 * consultas auxiliares usadas pela área administrativa.
 */
final class Produto
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Lista todos os produtos com o nome da categoria.
     */
    public function all(): array
    {
        $sql = 'SELECT p.id, p.sku, p.nome, p.descricao, p.preco_venda, p.preco_custo,
                       p.estoque, p.estoque_minimo, p.status, p.imagem,
                       c.nome AS categoria
                FROM produtos p
                INNER JOIN categorias c ON c.id = p.categoria_id
                ORDER BY p.nome';

        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Busca um produto pelo id.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        $produto = $stmt->fetch();

        return $produto ?: null;
    }

    /**
     * Cadastra um produto e retorna o id gerado.
     */
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO produtos
                (categoria_id, sku, nome, descricao, preco_venda, preco_custo,
                 estoque, estoque_minimo, status, imagem)
             VALUES
                (:categoria_id, :sku, :nome, :descricao, :preco_venda, :preco_custo,
                 :estoque, :estoque_minimo, :status, :imagem)'
        );

        $stmt->execute([
            'categoria_id' => $data['categoria_id'],
            'sku' => $data['sku'],
            'nome' => $data['nome'],
            'descricao' => $data['descricao'] ?? null,
            'preco_venda' => $data['preco_venda'],
            'preco_custo' => $data['preco_custo'] ?? 0,
            'estoque' => $data['estoque'] ?? 0,
            'estoque_minimo' => $data['estoque_minimo'] ?? 5,
            'status' => $data['status'] ?? 'disponivel',
            'imagem' => $data['imagem'] ?? null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Atualiza um produto existente.
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE produtos SET
                categoria_id = :categoria_id,
                sku = :sku,
                nome = :nome,
                descricao = :descricao,
                preco_venda = :preco_venda,
                preco_custo = :preco_custo,
                estoque = :estoque,
                estoque_minimo = :estoque_minimo,
                status = :status,
                imagem = :imagem
             WHERE id = :id'
        );

        return $stmt->execute([
            'categoria_id' => $data['categoria_id'],
            'sku' => $data['sku'],
            'nome' => $data['nome'],
            'descricao' => $data['descricao'] ?? null,
            'preco_venda' => $data['preco_venda'],
            'preco_custo' => $data['preco_custo'] ?? 0,
            'estoque' => $data['estoque'] ?? 0,
            'estoque_minimo' => $data['estoque_minimo'] ?? 5,
            'status' => $data['status'] ?? 'disponivel',
            'imagem' => $data['imagem'] ?? null,
            'id' => $id,
        ]);
    }

    /**
     * Exclui um produto.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM produtos WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Lista as categorias para os formulários.
     */
    public function categorias(): array
    {
        return $this->pdo
            ->query('SELECT id, nome FROM categorias ORDER BY nome')
            ->fetchAll();
    }

    /**
     * Lista os produtos com estoque igual ou abaixo do mínimo.
     */
    public function lowStock(): array
    {
        return $this->pdo
            ->query(
                'SELECT id, nome, estoque, estoque_minimo
                 FROM produtos
                 WHERE estoque <= estoque_minimo
                 ORDER BY (CAST(estoque AS SIGNED) - CAST(estoque_minimo AS SIGNED)), nome'
            )
            ->fetchAll();
    }
}
