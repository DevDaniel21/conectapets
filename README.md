# ConectaPets

Projeto de gerenciamento de usuários desenvolvido em PHP puro com MySQL e PDO, utilizando Composer para gerenciamento de dependências e Dotenv para variáveis de ambiente.

## Estrutura do projeto

```
conectapets/
├── index.php              # Front Controller - centraliza as rotas
├── .env                   # Variáveis de ambiente (não versionado)
├── composer.json          # Dependências do Composer
├── composer.lock
├── .gitignore
├── config/
│   ├── conexao.php        # Conexão PDO com MySQL e carregamento do .env
│   └── session.php        # Inicialização de sessão PHP
├── controller/
│   ├── authController.php # Controller de autenticação (login)
│   └── userController.php # Controller de cadastro de usuário
├── model/
│   ├── userModel.php      # Model com consultas SQL (CRUD de usuário)
│   └── php_upload_delete.php # Upload/delete de imagem via Cloudinary
├── view/
│   ├── login.php          # Página de login
│   ├── cadastro.php       # Página de cadastro
│   ├── cadastro_post.php  # Página de upload de imagem
│   └── home.php           # Página home (logado)
└── vendor/                # Dependências do Composer (não versionado)
```

## Fluxo de navegação

- `http://localhost/conectapets/` → Página de login
- `index.php?acao=cadastrar` → Página de cadastro
- `index.php?acao=login` (POST) → Autentica o usuário
- `index.php?acao=salvar_cadastro` (POST) → Cadastra novo usuário
- `index.php?acao=home` → Página home (após login/cadastro)
- `index.php?acao=sair` → Encerra a sessão (logout)
- `index.php?acao=excluir_conta` → Exclui a conta do usuário logado

## Requisitos

- PHP 7.4 ou superior
- MySQL
- Composer
- XAMPP (ou similar) para ambiente local

## Como rodar

1. Clone ou baixe o projeto na pasta `htdocs` do XAMPP:
   ```
   C:\xampp\htdocs\conectapets
   ```

2. Instale as dependências:
   ```
   composer install
   ```

3. Crie o banco de dados no MySQL:
   ```sql
   CREATE DATABASE conectapets;
   ```

4. Crie a tabela de usuários:
   ```sql
   CREATE TABLE usuario (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(100) NOT NULL,
       email VARCHAR(150) NOT NULL UNIQUE,
       senha VARCHAR(255) NOT NULL,
       telefone VARCHAR(20)
   );
   ```

5. Configure o arquivo `.env` na raiz do projeto:
   ```env
   HOST=localhost
   DATABASE=conectapets
   USER=root
   PASS=""

   CLOUDINARY_URL=cloudinary://SUA_CHAVE:SEU_SECRET@seu_cloud
   ```

6. Acesse pelo navegador:
   ```
   http://localhost/conectapets/
   ```

## Tecnologias

<div align="center">

<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" width="50" alt="PHP" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" width="50" alt="MySQL" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/composer/composer-original.svg" width="50" alt="Composer" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/dotenv/dotenv-original.svg" width="50" alt="Dotenv" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" width="50" alt="HTML5" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" width="50" alt="CSS3" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" width="50" alt="JavaScript" />
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" width="50" alt="Bootstrap" />

</div>

- PHP puro
- MySQL com PDO
- Composer
- vlucas/phpdotenv
- cloudinary/cloudinary_php
- Cloudinary (uploads de imagem)
- Bootstrap 5.3 (via CDN no modal de exclusão)

## Licença

Livre para estudo e uso.