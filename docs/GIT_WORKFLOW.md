# Git Workflow da Equipe

> Este guia mostra como a equipe deve trabalhar com branches, commits, pull requests e revisão.

## Para que serve

Use este documento sempre que houver uma entrega nova, uma correção ou uma alteração que precise passar por revisão.

## Fluxo padrão

```text
Issue → Branch → Desenvolvimento → Commit → Push → Pull Request → Review → Merge
```

## Criando uma branch

```bash
git checkout main
git pull origin main
git checkout -b feature/nome-da-feature
```

## Durante o desenvolvimento

```bash
git status
git add .
git commit -m "feat: descreve a entrega"
git push -u origin feature/nome-da-feature
```

Depois, abra o Pull Request no GitHub.

## Após o merge

```bash
git checkout main
git pull origin main
git branch -d feature/nome-da-feature
```

## Regra

Não utilize `git push --force` em branches compartilhadas sem orientação do professor.
