# Exemplo — Pull Request

> Use este arquivo como referência para descrever o conteúdo de um Pull Request antes da revisão.

## feat: implementa cadastro inicial de serviços

### Resumo

Implementa o formulário da área administrativa para cadastrar os serviços oferecidos pela empresa.

### Alterações

**Front-end**
- Criado formulário seguindo o Figma;
- Adicionada validação visual dos campos obrigatórios.

**Back-end**
- Criado processamento do formulário em PHP;
- Adicionada validação antes da persistência.

**Banco**
- Criada/atualizada tabela `services`;
- Atualizado `database/database.sql`.

### Como testar

1. Iniciar Apache e MySQL no XAMPP;
2. Importar/atualizar o banco;
3. Entrar na área administrativa;
4. Cadastrar um serviço;
5. Conferir o registro no phpMyAdmin.

### Checklist

- [x] Testado localmente;
- [x] SQL atualizado;
- [x] Nenhuma credencial enviada ao repositório;
- [x] Issue relacionada informada;
- [ ] Aguardando Code Review.

Closes #12
