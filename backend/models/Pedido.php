<?php

declare(strict_types=1);

/**
 * Model da tabela `pedidos` e de seus itens.
 *
 * Um pedido nasce do carrinho do cardápio público. A criação acontece em uma
 * única transação: pedido, itens, baixa de estoque e histórico de movimentação.
 */
final class Pedido
{
    public const STATUS = [
        'recebido' => 'Recebido',
        'em_preparo' => 'Em preparo',
        'pronto' => 'Pronto',
        'entregue' => 'Entregue',
        'cancelado' => 'Cancelado',
    ];

    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Cria o pedido com seus itens e dá a baixa no estoque.
     *
     * @param array<int, array{id:int, nome:string, preco:float, quantidade:int}> $itens
     */
    public function criar(
        int $clienteId,
        array $itens,
        ?string $observacoes,
        MovimentoEstoque $movimentos
    ): int {
        if ($itens === []) {
            throw new InvalidArgumentException('O carrinho está vazio.');
        }

        $total = 0.0;
        foreach ($itens as $item) {
            $total += (float) $item['preco'] * (int) $item['quantidade'];
        }

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO pedidos (cliente_id, status, total, observacoes)
                 VALUES (:cliente_id, :status, :total, :observacoes)'
            );
            $stmt->execute([
                'cliente_id' => $clienteId,
                'status' => 'recebido',
                'total' => $total,
                'observacoes' => $observacoes !== '' ? $observacoes : null,
            ]);

            $pedidoId = (int) $this->pdo->lastInsertId();

            $itemStmt = $this->pdo->prepare(
                'INSERT INTO pedidos_itens
                    (pedido_id, produto_id, quantidade, preco_unitario)
                 VALUES
                    (:pedido_id, :produto_id, :quantidade, :preco_unitario)'
            );

            foreach ($itens as $item) {
                $itemStmt->execute([
                    'pedido_id' => $pedidoId,
                    'produto_id' => (int) $item['id'],
                    'quantidade' => (int) $item['quantidade'],
                    'preco_unitario' => (float) $item['preco'],
                ]);

                // Mesma transação: sem nova transação interna (5º parâmetro = false).
                $movimentos->registrar(
                    (int) $item['id'],
                    null,
                    'saida',
                    (int) $item['quantidade'],
                    'Pedido #' . $pedidoId,
                    false
                );
            }

            $this->pdo->commit();

            return $pedidoId;
        } catch (Throwable $erro) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $erro;
        }
    }

    /**
     * Lista os pedidos para o painel administrativo.
     */
    public function listar(): array
    {
        $sql = 'SELECT p.id, p.status, p.total, p.observacoes, p.created_at,
                       c.nome AS cliente, c.telefone,
                       (SELECT COUNT(*) FROM pedidos_itens i
                        WHERE i.pedido_id = p.id) AS total_itens
                FROM pedidos p
                INNER JOIN clientes c ON c.id = p.cliente_id
                ORDER BY p.created_at DESC, p.id DESC';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $sql = 'SELECT p.*, c.nome AS cliente, c.telefone, c.email, c.endereco
                FROM pedidos p
                INNER JOIN clientes c ON c.id = p.cliente_id
                WHERE p.id = :id
                LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $pedido = $stmt->fetch();

        return $pedido ?: null;
    }

    public function itens(int $pedidoId): array
    {
        $sql = 'SELECT i.quantidade, i.preco_unitario, pr.nome AS produto, pr.sku
                FROM pedidos_itens i
                INNER JOIN produtos pr ON pr.id = i.produto_id
                WHERE i.pedido_id = :pedido_id
                ORDER BY pr.nome';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pedido_id' => $pedidoId]);

        return $stmt->fetchAll();
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        if (!array_key_exists($status, self::STATUS)) {
            throw new InvalidArgumentException('Status inválido.');
        }

        $stmt = $this->pdo->prepare(
            'UPDATE pedidos SET status = :status WHERE id = :id'
        );

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
