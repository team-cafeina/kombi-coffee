<?php

declare(strict_types=1);

/**
 * Carrinho do cardápio, armazenado na sessão PHP.
 *
 * O cliente não faz login, então o carrinho vive na sessão. Cada item é
 * guardado como [id_do_produto => quantidade].
 */
final class Carrinho
{
    public function __construct()
    {
        if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    /**
     * Adiciona unidades de um produto ao carrinho.
     */
    public function adicionar(int $produtoId, int $quantidade): void
    {
        if ($quantidade <= 0) {
            return;
        }

        $atual = (int) ($_SESSION['carrinho'][$produtoId] ?? 0);
        $_SESSION['carrinho'][$produtoId] = $atual + $quantidade;
    }

    /**
     * Remove uma ou todas as unidades de um produto.
     */
    public function diminuir(int $produtoId, int $quantidade): void
    {
        if (!isset($_SESSION['carrinho'][$produtoId])) {
            return;
        }

        $restante = (int) $_SESSION['carrinho'][$produtoId] - $quantidade;

        if ($restante <= 0) {
            $this->remover($produtoId);
            return;
        }

        $_SESSION['carrinho'][$produtoId] = $restante;
    }

    public function remover(int $produtoId): void
    {
        unset($_SESSION['carrinho'][$produtoId]);
    }

    public function limpar(): void
    {
        $_SESSION['carrinho'] = [];
    }

    /**
     * @return array<int, int> mapa produto_id => quantidade
     */
    public function itens(): array
    {
        $itens = [];

        foreach ($_SESSION['carrinho'] as $produtoId => $quantidade) {
            $itens[(int) $produtoId] = max(1, (int) $quantidade);
        }

        return $itens;
    }

    public function quantidadeItens(): int
    {
        return array_sum($this->itens());
    }
}
