# BarberFlow — Sistema de Agendamento para Barbearia

## Sobre

Aplicação web para clientes consultarem serviços e solicitarem horários, com área administrativa para gerenciamento de serviços e agendamentos.

## Tecnologias

- PHP
- MySQL / phpMyAdmin
- HTML
- CSS
- Bootstrap
- XAMPP

## Funcionalidades

- Login administrativo;
- CRUD de serviços;
- Cadastro de clientes;
- Agendamento de horários;
- Área administrativa protegida.

## Entidades

```text
clientes (1) ---- (N) agendamentos (N) ---- (1) servicos
```

## Execução

Clone em `C:\xampp\htdocs\barberflow`, inicie Apache/MySQL e acesse `http://localhost/barberflow/`.
