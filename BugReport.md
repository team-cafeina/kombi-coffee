# Exemplo — Bug Report

> Use este arquivo como base para abrir uma Issue de bug no GitHub.

## [BUG] Login não redireciona para a área administrativa

### Descrição

Ao informar credenciais válidas, o sistema permanece na tela de Login e não cria a sessão esperada.

### Passos para reproduzir

1. Iniciar Apache e MySQL no XAMPP;
2. Acessar a página de Login;
3. Informar um usuário válido cadastrado no MySQL;
4. Clicar em **Entrar**.

### Comportamento esperado

O usuário autenticado deve ter sua sessão criada e ser redirecionado para a área administrativa.

### Comportamento atual

A página é recarregada e o usuário continua na tela de Login.

### Critérios de aceitação

- [ ] Sessão é criada corretamente;
- [ ] Usuário é redirecionado;
- [ ] Credenciais inválidas continuam sendo bloqueadas;
- [ ] Fluxo foi validado no XAMPP.
