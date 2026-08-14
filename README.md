# Projeto Integrador - PHP + MySQL

Repositório-base para os alunos do **2º semestre do curso de Sistemas de Informação do Centro Universitário Senac** desenvolverem a disciplina de **Projeto Integrador II**.

Este template organiza a estrutura inicial, os materiais de apoio, os modelos de Issues e Pull Request, as orientações de Git/GitHub e a base técnica para uma aplicação em **PHP, MySQL, HTML, CSS, Bootstrap e XAMPP**.

## O que este repositório entrega

- Estrutura inicial do projeto;
- Documentação para orientar a equipe do início ao fim;
- Templates para Issues e Pull Requests;
- Base para front-end, back-end e banco de dados;
- Arquivos de apoio para organização da equipe.

## Mapa da documentação

| Arquivo | Para que serve |
|---|---|
| `README.md` | Página principal do repositório. Explica o propósito do template, os passos iniciais e onde encontrar cada documento. |
| `START_HERE.md` | Checklist curto para a equipe iniciar o projeto sem precisar ler tudo de uma vez. |
| `docs/PROJECT_DEFINITION.md` | Documento da Atividade 01. Registra equipe, proposta, funcionalidades, entidades e links do projeto. |
| `docs/ARQUITETURA.md` | Resume a organização das pastas e o fluxo básico entre interface, PHP e banco. |
| `docs/GIT_WORKFLOW.md` | Guia de colaboração com branches, commits, pull requests e revisão. |
| `docs/SETUP_XAMPP.md` | Guia para executar o projeto localmente com XAMPP, Apache, MySQL e phpMyAdmin. |
| `docs/PROFESSOR_SETUP.md` | Checklist do professor para publicar o template corretamente para a turma. |
| `docs/IDENTIDADE_VISUAL.md` | Registro da identidade visual definida no Figma e dos componentes principais. |
| `database/README.md` | Explica como versionar a estrutura do banco e o uso do `database.sql`. |
| `BugReport.md` | Exemplo de template para registrar bugs na raiz do repositório. |
| `FeatureRequest.md` | Exemplo de template para propor funcionalidades. |
| `PullRequest.md` | Exemplo de template para documentar Pull Requests. |
| `.github/ISSUE_TEMPLATE/*.yml` | Formulários oficiais de Issue usados pelo GitHub. |
| `.github/PULL_REQUEST_TEMPLATE.md` | Template oficial de Pull Request usado pelo GitHub. |
| `.github/CODEOWNERS` | Regras de revisão e responsabilidade do repositório. |
| `readme_exemples/` | Exemplos de escrita e estrutura para apoiar a personalização da documentação. |

## Estrutura principal do projeto

| Caminho | Função |
|---|---|
| `index.php` | Ponto de entrada da raiz. Redireciona para a interface em `frontend/`. |
| `frontend/` | Camada visual da aplicação. Contém a home inicial, páginas, CSS, JavaScript e assets. |
| `backend/` | Camada de back-end em PHP. Concentra configuração, regras de negócio e futura integração com o banco. |
| `database/` | Scripts SQL e documentação do banco de dados do projeto. |
| `docs/` | Documentos de apoio, definição, arquitetura, setup e governança. |
| `.github/` | Templates e configurações de colaboração no GitHub. |

## Como começar

1. Dê `Star` no repositório-base;
2. Crie a `Organization` da equipe;
3. Convide os integrantes e o professor;
4. Faça o `Fork` para a `Organization`;
5. Clone o repositório dentro de `C:\xampp\htdocs`;
6. Inicie `Apache` e `MySQL` no XAMPP;
7. Acesse `http://localhost/NOME-DO-REPOSITORIO/`;
8. Leia `START_HERE.md` e preencha `docs/PROJECT_DEFINITION.md`;
9. Atualize os links do Figma, board e repositório;
10. Crie as primeiras Issues e comece o fluxo em branch.

## Ambiente local

O projeto foi preparado para uso com **XAMPP**.

- `Apache` executa a aplicação;
- `PHP` processa as páginas;
- `MySQL` armazena os dados;
- `phpMyAdmin` administra o banco;
- `frontend/index.php` representa a tela inicial do template;
- `backend/config/database.example.php` serve como base para a configuração local do banco;
- `database/database.sql` concentra a estrutura inicial do banco do projeto.

## Regras de colaboração

- Não desenvolva diretamente na `main`;
- Não versionar credenciais ou senhas em texto puro;
- Use Issues para organizar trabalho;
- Use Pull Requests para integrar mudanças;
- Mantenha o README e os documentos atualizados conforme o projeto evoluir;
- Preserve o repositório público durante a disciplina;
- Prefira commits claros, objetivos e relacionados à entrega realizada.

## Requisitos mínimos do projeto final

- Tela de login com autenticação via banco de dados;
- Área administrativa protegida;
- Pelo menos duas entidades relacionadas;
- CRUD completo de pelo menos uma entidade principal;
- Front-end, back-end e banco integrados;
- Interface funcional, navegável e consistente com a identidade visual da equipe.

## Entregáveis da Atividade 01

- Nome da equipe definido;
- Grupo com no máximo 4 integrantes;
- Papéis principais definidos;
- Segmento escolhido;
- Nome da aplicação definido;
- Problema, objetivo e público-alvo descritos;
- Funcionalidades iniciais levantadas;
- Manual de Identidade Visual criado no Figma;
- Logo, cores e tipografia definidos;
- Board de tarefas criado;
- Links do Figma e do board adicionados ao repositório.

## Entregáveis da Atividade 02

- Organization criada com o nome da equipe;
- Repositório público dentro da Organization;
- Professor convidado;
- Integrantes convidados;
- Fork realizado;
- Star realizada no repositório-base;
- Clone realizado dentro do `htdocs`;
- README personalizado;
- Estrutura inicial organizada;
- `.gitignore` configurado;
- Templates de Issues disponíveis;
- Template de Pull Request disponível;
- Issues iniciais criadas;
- Front-end inicial executando no XAMPP;
- Bootstrap configurado;
- Estrutura do back-end preparada;
- Estrutura do banco preparada;
- Pelo menos uma branch criada;
- Pelo menos um Pull Request aberto;
- Pelo menos um Code Review realizado;
- Pelo menos um Merge realizado via Pull Request.

## Links do projeto

> A equipe deve substituir os placeholders abaixo pelos links reais.

- `Figma`: `INSERIR_LINK_FIGMA`
- `Board de tarefas`: `INSERIR_LINK_BOARD`
- `GitHub Organization`: `INSERIR_LINK_ORGANIZATION`
- `Repositório`: `INSERIR_LINK_REPOSITORIO`

## Equipe

> Substitua a tabela abaixo pelos integrantes reais.

| Integrante | GitHub | Responsabilidade principal |
|---|---|---|
| Nome 01 | `@usuario` | Back-end Lead |
| Nome 02 | `@usuario` | Front-end Lead |
| Nome 03 | `@usuario` | Design Lead |
| Nome 04 | `@usuario` | Project Management Lead |

## Primeiro teste

Depois de clonar o projeto dentro de `C:\xampp\htdocs`, acesse:

```text
http://localhost/NOME-DO-REPOSITORIO/
```

Se a página inicial do template aparecer, o ambiente básico está funcionando.

## Próximos passos

1. Personalize o nome do projeto e da equipe;
2. Preencha `docs/PROJECT_DEFINITION.md`;
3. Atualize `docs/IDENTIDADE_VISUAL.md`;
4. Registre a arquitetura e o fluxo de Git nos documentos de apoio;
5. Substitua o template pela solução real da equipe.
