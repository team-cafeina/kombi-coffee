<?php

declare(strict_types=1);

/**
 * Model das movimentações de estoque.
 *
 * Registra entradas e saídas e atualiza o saldo do produto na mesma transação,
 * garantindo que o histórico nunca fique diferente do estoque atual.
 */
final class MovimentoEstoque
{
    private const TIPOS = ['entrada', 'saida'];

    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Registra uma movimentação e ajusta o estoque do produto.
     *
     * @throws InvalidArgumentException quando os dados informados são inválidos
     * @throws RuntimeException quando o produto não existe ou o saldo é insuficiente
     */
    public function registrar(
        int $produtoId,
        int $usuarioId,
        string $tipo,
        int $quantidade,
        ?string $observacao = null
    ): void {
        if (!in_array($tipo, self::TIPOS, true)) {
            throw new InvalidArgumentException('Tipo de movimentação inválido.');
        }

        if ($quantidade <= 0) {
            throw new InvalidArgumentException('A quantidade deve ser maior que zero.');
        }

        $this->pdo->beginTransaction();

        try {
            $consulta = $this->pdo->prepare(
                'SELECT estoque FROM produtos WHERE id = :id FOR UPDATE'
            );
            $consulta->execute(['id' => $produtoId]);
            $produto = $consulta->fetch();

            if ($produto === false) {
                throw new RuntimeException('Produto não encontrado.');
            }

            $estoqueAtual = (int) $produto['estoque'];

            if ($tipo === 'saida' && $quantidade > $estoqueAtual) {
                throw new RuntimeException(
                    'Estoque insuficiente. Disponível: ' . $estoqueAtual . ' unidade(s).'
                );
            }

            $novoEstoque = $tipo === 'entrada'
                ? $estoqueAtual + $quantidade
                : $estoqueAtual - $quantidade;

            $this->pdo->prepare(
                'UPDATE produtos SET estoque = :estoque WHERE id = :id'
            )->execute([
                'estoque' => $novoEstoque,
                'id' => $produtoId,
            ]);

            $this->pdo->prepare(
                'INSERT INTO movimentacoes_estoque
                    (produto_id, usuario_id, tipo, quantidade, observacao)
                 VALUES
                    (:produto_id, :usuario_id, :tipo, :quantidade, :observacao)'
            )->execute([
                'produto_id' => $produtoId,
                'usuario_id' => $usuarioId,
                'tipo' => $tipo,
                'quantidade' => $quantidade,
                'observacao' => $observacao !== null && $observacao !== '' ? $observacao : null,
            ]);

            $this->pdo->commit();
        } catch (Throwable $erro) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $erro;
        }
    }

    /**
     * Últimas movimentações, com nome de produto e de usuário.
     */
    public function recentes(int $limite = 10): array
    {
        $sql = 'SELECT m.id, m.tipo, m.quantidade, m.observacao, m.created_at,
                       p.nome AS produto, p.sku, u.name AS usuario
                FROM movimentacoes_estoque m
                INNER JOIN produtos p ON p.id = m.produto_id
                INNER JOIN users u ON u.id = m.usuario_id
                ORDER BY m.created_at DESC, m.id DESC
                LIMIT :limite';

        $consulta = $this->pdo->prepare($sql);
        $consulta->bindValue('limite', $limite, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll();
    }

    /**
     * Indicadores gerais do estoque.
     */
    public function totais(): array
    {
        $resultado = $this->pdo->query(
            'SELECT COUNT(*) AS produtos,
                    COALESCE(SUM(estoque), 0) AS unidades,
                    COALESCE(SUM(estoque * preco_venda), 0) AS valor_venda
             FROM produtos'
        )->fetch();

        return [
            'produtos' => (int) $resultado['produtos'],
            'unidades' => (int) $resultado['unidades'],
            'valor_venda' => (float) $resultado['valor_venda'],
        ];
    }
}
