<?php

declare(strict_types=1);

/**
 * Model da tabela `clientes`.
 *
 * O cliente do cardápio não possui conta nem senha: ele só informa nome e
 * telefone no checkout para que o pedido possa ser identificado.
 */
final class Cliente
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Busca um cliente pelo telefone (forma prática de reaproveitar o cadastro).
     */
    public function buscarPorTelefone(string $telefone): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM clientes WHERE telefone = :telefone LIMIT 1'
        );
        $stmt->execute(['telefone' => $telefone]);
        $cliente = $stmt->fetch();

        return $cliente ?: null;
    }

    /**
     * Cadastra um novo cliente e retorna o id gerado.
     */
    public function criar(
        string $nome,
        ?string $email,
        string $telefone,
        ?string $endereco
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO clientes (nome, email, telefone, endereco)
             VALUES (:nome, :email, :telefone, :endereco)'
        );
        $stmt->execute([
            'nome' => $nome,
            'email' => $email !== '' ? $email : null,
            'telefone' => $telefone,
            'endereco' => $endereco !== '' ? $endereco : null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Retorna um cliente já existente pelo telefone ou cria um novo.
     */
    public function obterOuCriar(
        string $nome,
        ?string $email,
        string $telefone,
        ?string $endereco
    ): int {
        $cliente = $this->buscarPorTelefone($telefone);

        if ($cliente !== null) {
            return (int) $cliente['id'];
        }

        return $this->criar($nome, $email, $telefone, $endereco);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $cliente = $stmt->fetch();

        return $cliente ?: null;
    }
}
