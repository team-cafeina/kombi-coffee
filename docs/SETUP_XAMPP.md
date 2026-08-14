# Setup com XAMPP

> Este documento orienta a execução local do projeto com Apache, PHP, MySQL e phpMyAdmin.

## Para que serve

Use este guia quando for configurar o ambiente local pela primeira vez ou quando outra pessoa da equipe precisar reproduzir a aplicação.

## 1. Instalação

Instale o XAMPP e confirme que o **Apache** e o **MySQL** conseguem iniciar normalmente.

## 2. Local do projeto

No Windows, mantenha o repositório dentro de:

```text
C:\xampp\htdocs\
```

Exemplo:

```text
C:\xampp\htdocs\agenda-facil\
```

## 3. Abrindo o projeto

Com Apache ativo:

```text
http://localhost/agenda-facil/
```

## 4. phpMyAdmin

Com MySQL ativo:

```text
http://localhost/phpmyadmin
```

Importe `database/database.sql` depois de personalizá-lo para o banco do projeto.

## 5. Configuração local do banco

Copie:

```text
backend/config/database.example.php
```

para:

```text
backend/config/database.php
```

Depois ajuste nome do banco, usuário e senha de acordo com o ambiente local.

`database.php` não deverá ser enviado ao GitHub.
