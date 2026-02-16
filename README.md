# Laravel News API

Aplicação desenvolvida em Laravel que fornece uma API REST e uma interface web para gerenciamento de usuários, categorias e postagens de notícias, com autenticação via Laravel Sanctum.

## Tecnologias utilizadas

- PHP 8.2
- Laravel
- Laravel Sanctum
- SQLite
- Blade (views web)

## Funcionalidades

### API

- Cadastro e login de usuários
- Autenticação via Bearer Token (Sanctum)
- CRUD de categorias
- CRUD de postagens
- Paginação e filtros
- Policies para controle de autorização
- Command Artisan para atualização em massa de títulos

### Web

- Autenticação de usuários
- Listagem de postagens
- Criação, edição e exclusão de postagens
- Autorização baseada no usuário autenticado
## Instalação

```bash
git clone <url-do-repositorio>
cd laravel-news-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
A aplicação ficará disponível em:
```bash
http://127.0.0.1:8000
```  

## Autenticação da API
A API utiliza autenticação via Laravel Sanctum (Bearer Token).

### Registrar usuário
POST /api/register

```bash
Body:
{
  "name": "Usuario",
  "email": "user@test.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Login
POST /api/login

Retorna um token Bearer para autenticação.

### Logout
POST /api/logout
Auth: Bearer Token

### Usuário autenticado
GET /api/me
Auth: Bearer Token

### Categorias (Auth obrigatório)

GET    /api/categories  
POST   /api/categories  
PUT    /api/categories/{id}  
DELETE /api/categories/{id}

## Postagens

### Listar postagens
GET /api/posts

Paginação automática.

Filtro opcional:

```bash
/api/posts?category_id=1
/api/posts?title=exemplo
```

### Criar postagem
POST /api/posts
Auth: Bearer Token

Body:
```bash
{
  "title": "Título",
  "summary": "Resumo",
  "content": "Conteúdo",
  "category_id": 1
}
```

### Command Artisan
Comando para atualizar o título de todas as postagens:

```bash
php artisan posts:update-title "Novo título"
```

## Observações
- O projeto utiliza Policies para garantir que apenas o autor da postagem possa editá-la ou removê-la.

- A API e a interface web compartilham a mesma base de dados.

- Seeders estão disponíveis para usuários, categorias e postagens.

## Consideração final
Este projeto foi desenvolvido com foco em boas práticas, organização de código e separação de responsabilidades, visando um cenário real de uso em aplicações Laravel.