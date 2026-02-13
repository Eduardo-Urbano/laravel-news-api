# Laravel News API

API REST desenvolvida em Laravel para gerenciamento de usuários, categorias e postagens de notícias, com autenticação via Sanctum.

## Tecnologias utilizadas

- PHP 8.2
- Laravel
- Laravel Sanctum
- SQLite

## Funcionalidades

- Cadastro e login de usuários
- Autenticação via Bearer Token
- CRUD de categorias
- CRUD de postagens
- Paginação e filtros
- Policies para controle de autorização
- Command Artisan para atualização de títulos

## Instalação

```bash
git clone <url-do-repositorio>
cd laravel-news-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

# API de Notícias — Laravel

## Autenticação
A API utiliza autenticação via Laravel Sanctum (Bearer Token).

### Registrar usuário
POST /api/register

Body:
{
  "name": "Eduardo",
  "email": "edu@test.com",
  "password": "123456",
  "password_confirmation": "123456"
}

### Login
POST /api/login

Retorna token Bearer.

### Logout
POST /api/logout
Auth: Bearer Token

### Usuário autenticado
GET /api/me
Auth: Bearer Token

## Categorias (Auth obrigatório)

GET    /api/categories  
POST   /api/categories  
PUT    /api/categories/{id}  
DELETE /api/categories/{id}

## Postagens

### Listar postagens
GET /api/posts

Paginação automática.

Filtro opcional:
GET /api/posts?category_id=1

### Criar postagem
POST /api/posts
Auth: Bearer Token

Body:
{
  "title": "Título",
  "summary": "Resumo",
  "content": "Conteúdo",
  "category_id": 1
}