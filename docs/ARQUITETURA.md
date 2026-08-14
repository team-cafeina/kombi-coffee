# Arquitetura Inicial

> Este documento explica a função das pastas do template e o fluxo básico entre interface, PHP e banco de dados.

## Para que serve

Use esta referência para orientar a organização do código e evitar misturar interface, regra de negócio e SQL no mesmo arquivo.

## Estrutura

```text
frontend/   → interface e páginas
backend/    → regras de negócio e acesso a dados
database/   → scripts SQL
docs/       → documentação
.github/    → governança do repositório
```

## Princípio da organização

Evite concentrar HTML, consultas SQL, regras de negócio e estilos em um único arquivo. A estrutura poderá evoluir durante a disciplina conforme novos conceitos forem apresentados.

## Fluxo conceitual

```text
Usuário
  ↓
Interface (HTML/CSS/Bootstrap)
  ↓
PHP
  ↓
MySQL
```
