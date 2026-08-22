# Projeto Integrador — PHP + MySQL

> Repositório-base da disciplina para iniciar o Projeto Integrador utilizando **PHP puro, MySQL, phpMyAdmin, HTML, CSS, JavaScript, Bootstrap, XAMPP, Git e GitHub**.

Este repositório **não é um projeto pronto**. Ele contém a estrutura inicial, exemplos, templates e orientações que cada equipe deverá adaptar para o próprio projeto

---

## Materiais da disciplina

> **Professor:** substitua os três placeholders abaixo pelos links oficiais antes de disponibilizar o repositório aos alunos.

- 📊 **Aula 01 — Definição do Projeto:** [`INSERIR_LINK_PPT_AULA_01`](https://docs.google.com/presentation/d/1aHc31MrEDHxEBw8pOtDuAwAxgzIZJi4l/edit?usp=sharing&ouid=112595941029232116373&rtpof=true&sd=true)
- 🌿 **Aula 02 — Git e GitHub:** [`INSERIR_LINK_PPT_AULA_02`](https://docs.google.com/presentation/d/1ooSOhHy7P4sLNeCdVd0QGIS4AEnzlNMK/edit?usp=sharing&ouid=112595941029232116373&rtpof=true&sd=true)
- 📚 **Notion da disciplina:** [`LINK_NOTION_DISCIPLINA`](https://deluxe-blue-bc1.notion.site/Projeto-Integrador-II-Aplica-o-Web-Din-mica-305dfca74d8d80ee9cf3dbbb08257c7c?source=copy_link)

---

# Antes de começar

Cada grupo deverá possuir **no máximo 4 integrantes**.

O projeto será desenvolvido durante a disciplina e deverá representar uma aplicação web para **prestação, contratação, agendamento ou gerenciamento de serviços**.

Independentemente do tema escolhido, o projeto final deverá possuir:

1. Tela de login com autenticação via banco de dados;
2. Área administrativa protegida;
3. Pelo menos duas entidades relacionadas no banco;
4. CRUD completo de pelo menos uma entidade principal;
5. Front-end, back-end e banco de dados integrados;
6. Interface funcional, navegável e consistente com a identidade visual definida pela equipe.

---

# Fluxo inicial obrigatório no GitHub

Antes de alterar qualquer arquivo, a equipe deverá preparar o ambiente de colaboração.

## 1. Dê uma Star neste repositório

Na página deste repositório no GitHub, clique em **Star**.

A Star será utilizada para marcar o repositório-base utilizado na disciplina.

## 2. Crie uma Organization no GitHub

A equipe deverá criar uma **GitHub Organization** utilizando, preferencialmente, o nome da equipe.

Exemplo:

```text
Equipe: DevForge
Organization: devforge
```

A Organization deverá concentrar o repositório oficial do grupo.

## 3. Adicione os integrantes

Convide para a Organization:

- Todos os integrantes da equipe;
- O professor: `@USUARIO_DO_PROFESSOR`.

> Substitua o placeholder pelo usuário informado pelo professor.

## 4. Faça o Fork

Clique em **Fork** neste repositório e, quando o GitHub solicitar o proprietário, selecione a **Organization da equipe**.

O repositório criado pelo Fork deverá permanecer **público**.

### Nome sugerido

Troque o nome pelo nome real da aplicação.

```text
agenda-facil
pet-care
fix-service
studio-booking
```

## 5. Faça o Clone

Como o projeto será executado com **XAMPP**, faça o clone dentro da pasta `htdocs`.

No Windows:

```bash
cd C:\xampp\htdocs
```

Depois:

```bash
git clone URL_DO_REPOSITORIO_DA_EQUIPE
```

Entre na pasta:

```bash
cd nome-do-projeto
```

Confira os remotes:

```bash
git remote -v
```

O `origin` deve apontar para o repositório da **Organization da equipe**.

---

# Ambiente de desenvolvimento — XAMPP

O projeto será executado localmente utilizando o **XAMPP**.

A equipe deverá utilizar:

- **Apache** — servidor local;
- **PHP** — back-end;
- **MySQL** — banco de dados;
- **phpMyAdmin** — administração do banco.

## Executando o projeto

1. Abra o **XAMPP Control Panel**;
2. Inicie **Apache**;
3. Inicie **MySQL**;
4. Certifique-se de que o repositório está dentro de `C:\xampp\htdocs`;
5. Abra o navegador;
6. Acesse:

```text
http://localhost/NOME-DO-REPOSITORIO/
```

O arquivo `index.php` da raiz redirecionará para a aplicação em `frontend/`.

## Acessando o phpMyAdmin

```text
http://localhost/phpmyadmin
```

O arquivo inicial do banco está em:

```text
database/database.sql
```

A equipe deverá **editar esse arquivo** de acordo com o modelo de dados do próprio projeto.

---

# ATIVIDADE 01 — Definição do Projeto

## Objetivo

Definir a proposta do projeto, a equipe, o segmento, o nome da aplicação e sua identidade visual antes do início da implementação.

## 1. Formação da equipe

Formem grupos com **no máximo 4 integrantes**.

Definam um responsável principal para cada área:

- **Back-end Lead** — PHP, regras de negócio, autenticação e banco;
- **Front-end Lead** — HTML, CSS, JavaScript, Bootstrap e integração das telas;
- **Design Lead** — identidade visual, componentes e protótipos no Figma;
- **Project Management Lead** — organização das tarefas, acompanhamento e governança do projeto.

> Os papéis indicam a responsabilidade principal. Todos deverão colaborar no desenvolvimento.

A equipe deverá registrar:

- Nome da equipe;
- Nome dos integrantes;
- Papel principal de cada integrante.

## 2. Escolha do segmento

Escolham um segmento relacionado à oferta ou gerenciamento de serviços.

### Sugestões

1. Barbearia ou salão de beleza;
2. Clínica odontológica;
3. Clínica veterinária ou Pet Shop;
4. Oficina mecânica;
5. Academia ou Personal Trainer;
6. Escola de idiomas ou aulas particulares;
7. Serviços de limpeza residencial;
8. Assistência técnica de computadores ou celulares;
9. Fotografia e eventos;
10. Serviços de manutenção residencial.

Outras propostas poderão ser utilizadas mediante validação do professor.

## 3. Definição da solução

A equipe deverá definir:

- Nome da aplicação;
- Segmento;
- Problema que será resolvido;
- Público-alvo;
- Objetivo principal;
- Funcionalidades iniciais previstas.

## 4. Identidade Visual no Figma

Criem um **Manual de Identidade Visual** contendo pelo menos:

- Logo principal;
- Versão reduzida/símbolo;
- Paleta de cores com códigos HEX;
- Tipografia para títulos e textos;
- Aplicação em fundo claro e escuro;
- Botão principal;
- Botão secundário;
- Campo de formulário;
- Card;
- Menu/Navbar;
- Mensagens de sucesso e erro.

O link do Figma deverá ser adicionado na seção **Links do Projeto** deste README.

## 5. Gestão das tarefas

Utilizem o board definido pelo professor para acompanhar o trabalho da equipe.

O fluxo mínimo deverá possuir:

```text
Backlog → Doing → Done
             ↓
          Blocking
```

Cada tarefa deverá possuir, sempre que aplicável:

- Título;
- Descrição;
- Responsável;
- Critérios de aceite;
- Prazo;
- Checklist.

## Entregáveis da Atividade 01

- [ ] Nome da equipe definido;
- [ ] Grupo com no máximo 4 integrantes;
- [ ] Líderes definidos;
- [ ] Segmento escolhido;
- [ ] Nome da aplicação definido;
- [ ] Problema e objetivo descritos;
- [ ] Público-alvo definido;
- [ ] Funcionalidades iniciais levantadas;
- [ ] Manual de Identidade Visual criado no Figma;
- [ ] Logo, cores e tipografia definidos;
- [ ] Board de tarefas criado e organizado;
- [ ] Links do Figma e board adicionados ao README.

---

# ATIVIDADE 02 — Setup do Projeto, Git e GitHub

## Objetivo

Preparar o repositório que será utilizado durante todo o projeto, aplicando boas práticas de organização, versionamento, Issues, branches, Pull Requests, Code Review e documentação.

## 1. Personalize este repositório

Após realizar Fork e Clone, a equipe deverá substituir todos os exemplos e placeholders pelo conteúdo real do projeto.

Comecem por:

- Nome da aplicação;
- Descrição;
- Integrantes;
- Responsabilidades;
- Links do Figma e gerenciamento;
- Estrutura necessária para o tema escolhido.

## 2. Branches

Não desenvolvam diretamente na `main`.

Utilizem branches como:

```text
feature/login
feature/home
feature/admin-dashboard
feature/cadastro-servicos
fix/login-validation
docs/update-readme
style/identity
```

Padrão recomendado:

```text
tipo/nome-da-tarefa
```

## 3. Issues

Este repositório já possui templates em:

```text
.github/ISSUE_TEMPLATE/
```

Templates disponíveis:

- Feature;
- Bug;
- Task técnica;
- Documentação.

Antes de desenvolver uma funcionalidade relevante, crie uma Issue.

Cada Issue deverá apresentar:

- Contexto;
- Objetivo;
- Escopo;
- Critérios de aceitação.

## 4. Pull Requests

O repositório possui um template em:

```text
.github/PULL_REQUEST_TEMPLATE.md
```

Toda alteração destinada à `main` deverá passar por Pull Request.

O fluxo esperado é:

```text
Issue
  ↓
Branch
  ↓
Desenvolvimento
  ↓
Commit
  ↓
Push
  ↓
Pull Request
  ↓
Code Review
  ↓
Merge
```

O Pull Request deverá ser revisado por **outro integrante da equipe** sempre que possível.

## 5. Commits

Utilizem mensagens claras e objetivas, preferencialmente seguindo **Conventional Commits**.

Exemplos:

```bash
git commit -m "feat: cria estrutura inicial da home"
git commit -m "feat: adiciona formulário de login"
git commit -m "fix: corrige validação do formulário"
git commit -m "style: aplica identidade visual"
git commit -m "docs: atualiza instruções do projeto"
git commit -m "refactor: reorganiza conexão com banco"
```

Evitem:

```text
teste
alteração
ajustes
final
commit novo
funcionando
```

## 6. Estrutura inicial

A estrutura-base deste repositório é:

```text
.
├── .github/
│   ├── ISSUE_TEMPLATE/
│   ├── PULL_REQUEST_TEMPLATE.md
│   └── CODEOWNERS
│
├── frontend/
│   ├── index.php
│   ├── pages/
│   ├── components/
│   ├── css/
│   ├── js/
│   └── assets/
│
├── backend/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   └── services/
│
├── database/
│   ├── migrations/
│   ├── seeds/
│   └── database.sql
│
├── docs/
├── readme_exemples/
├── index.php
├── .gitignore
└── README.md
```

A equipe poderá evoluir essa arquitetura conforme o projeto avançar.

## 7. Setup inicial do Front-end

A página inicial deverá utilizar:

- HTML;
- CSS;
- JavaScript quando necessário;
- Bootstrap.

O arquivo-base está em:

```text
frontend/index.php
```

A equipe deverá substituí-lo pela interface definida no Figma.

## 8. Setup inicial do Back-end

O back-end será desenvolvido com **PHP puro**.

A estrutura inicial está em:

```text
backend/
```

Existe um arquivo de exemplo para configuração do banco:

```text
backend/config/database.example.php
```

Copie-o para:

```text
backend/config/database.php
```

O arquivo `database.php` está no `.gitignore` e não deve ser versionado com credenciais reais.

## 9. Banco de Dados

Utilizem **MySQL + phpMyAdmin**.

O arquivo:

```text
database/database.sql
```

servirá como ponto inicial para versionar a estrutura do banco.

O projeto final deverá possuir pelo menos **duas entidades relacionadas**.

Exemplo:

```text
clientes 1 ─────── N agendamentos
```

A equipe deverá substituir esse exemplo pelo modelo do próprio projeto.

## 10. Primeiro fluxo colaborativo

Durante a Atividade 02, cada grupo deverá executar pelo menos uma vez:

```text
Criar Issue
   ↓
Criar Branch
   ↓
Alterar o projeto
   ↓
Criar Commit
   ↓
Realizar Push
   ↓
Abrir Pull Request
   ↓
Outro integrante revisar
   ↓
Realizar Merge
```

## Entregáveis da Atividade 02

- [ ] Organization criada com o nome da equipe;
- [ ] Repositório público dentro da Organization;
- [ ] Professor convidado;
- [ ] Todos os integrantes convidados;
- [ ] Fork realizado;
- [ ] Star realizada no repositório-base;
- [ ] Clone realizado dentro do `htdocs` do XAMPP;
- [ ] README personalizado;
- [ ] Estrutura inicial organizada;
- [ ] `.gitignore` configurado;
- [ ] Templates de Issues disponíveis;
- [ ] Template de Pull Request disponível;
- [ ] Issues iniciais criadas;
- [ ] Front-end inicial executando no XAMPP;
- [ ] Bootstrap configurado;
- [ ] Estrutura do back-end preparada;
- [ ] Estrutura do banco preparada;
- [ ] Pelo menos uma branch criada;
- [ ] Pelo menos um Pull Request aberto;
- [ ] Pelo menos um Code Review realizado;
- [ ] Pelo menos um Merge realizado via Pull Request.

---

# Requisitos obrigatórios do projeto final

Independentemente do segmento escolhido, o projeto deverá implementar:

## Autenticação

- Tela de login;
- Usuários armazenados no MySQL;
- Senhas armazenadas de forma segura utilizando `password_hash()`;
- Validação utilizando `password_verify()`;
- Sessão PHP para manter autenticação.

## Área administrativa

A área administrativa deverá ser protegida e acessível apenas para usuários autorizados.

Exemplo de rota/pasta:

```text
/frontend/pages/admin/
```

## Banco de dados

- MySQL;
- Gerenciamento via phpMyAdmin;
- Pelo menos duas entidades relacionadas;
- Chaves primárias;
- Chaves estrangeiras quando aplicável.

## CRUD

Pelo menos uma entidade principal deverá possuir:

- Create;
- Read;
- Update;
- Delete.

## Interface

A aplicação deverá ser:

- Funcional;
- Navegável;
- Organizada;
- Consistente com o Figma;
- Responsiva dentro do escopo definido pela equipe.

---

# Links do Projeto

> A equipe deverá atualizar esta seção.

- 🎨 **Figma:** `INSERIR_LINK_FIGMA`
- 📋 **Board de tarefas:** `INSERIR_LINK_BOARD`
- 🐙 **GitHub Organization:** `INSERIR_LINK_ORGANIZATION`
- 📦 **Repositório:** `INSERIR_LINK_REPOSITORIO`

---

# Equipe

> Substituam a tabela abaixo pelos integrantes reais.

| Integrante | GitHub | Responsabilidade principal |
|---|---|---|
| Nome 01 | `@usuario` | Back-end Lead |
| Nome 02 | `@usuario` | Front-end Lead |
| Nome 03 | `@usuario` | Design Lead |
| Nome 04 | `@usuario` | Project Management Lead |

---

# Regras importantes

- Não realizem desenvolvimento diretamente na `main`;
- Não versionem senhas ou credenciais;
- Não removam o histórico de commits da equipe;
- Utilizem Issues para organizar implementações;
- Utilizem Pull Requests para integrar mudanças;
- Atualizem o README conforme o projeto evoluir;
- Mantenham o repositório **público** durante a disciplina;
- Todos os integrantes devem participar dos commits e revisões.

---

# Primeiro teste

Depois de clonar o projeto dentro do `htdocs`, acesse:

```text
http://localhost/NOME-DO-REPOSITORIO/
```

Se a página inicial do template aparecer, o ambiente básico está funcionando.

A partir daqui, **o template deixa de ser do professor e passa a ser o projeto da equipe**. Personalizem a estrutura, a documentação e a aplicação para representar a solução definida na Atividade 01.
