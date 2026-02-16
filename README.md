# Laravel News API

Aplicação desenvolvida em Laravel que disponibiliza uma API REST autenticada e uma interface web para gerenciamento de usuários, categorias e postagens de notícias.

O projeto foi estruturado com separação clara entre camada de API e camada web, utilizando autenticação via Laravel Sanctum, Policies para autorização e boas práticas de organização de código.

---

## Tecnologias Utilizadas

- PHP 8.2
- Laravel 10+
- Laravel Sanctum
- SQLite (configuração padrão)
- Blade (interface web)

---

## Funcionalidades

### API REST

- Registro e login de usuários
- Autenticação via Bearer Token (Sanctum)
- CRUD completo de categorias
- CRUD completo de postagens
- Paginação automática
- Filtros por título e categoria
- Policies para controle de autorização (somente o autor pode editar ou excluir)
- Comando Artisan para atualização em massa de títulos

### Interface Web

- Autenticação de usuários
- Listagem paginada de postagens
- CRUD completo de postagens
- CRUD completo de categorias
- Confirmação antes de exclusão
- Autorização baseada no usuário autenticado

---

## Instalação

Clone o repositório:

```bash
git clone https://github.com/Eduardo-Urbano/laravel-news-api.git
cd laravel-news-api
```

## Instale as dependências:

```bash
composer install
```

## Configure o ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

## Execute as migrations e seeders:

```bash
php artisan migrate --seed
```

## Inicie o servidor:

```bash
php artisan serve
```

A aplicação estará disponível em:

```bash
http://127.0.0.1:8000
```

---

## Autenticação da API

A API utiliza Laravel Sanctum com autenticação via Bearer Token.

### Registro de usuário

```http
POST /api/register
```

Body:

```json
{
  "name": "Usuario",
  "email": "user@test.com",
  "password": "password",
  "password_confirmation": "password"
}
```

---

### Login

```http
POST /api/login
```
Retorna um token que deve ser enviado no header das requisições autenticadas:
```http
Authorization: Bearer {token}
```

---

### Usuário autenticado

```http
GET /api/me
```
Requer autenticação via Bearer Token.

---

## Postagens

Listar postagens:
```http
GET /api/posts
```
Filtros opcionais:
```http
/api/posts?category_id=1
/api/posts?title=exemplo
```
Criar postagem (Autenticado):
```http
POST /api/posts
```
Body:
```json
{
  "title": "Título",
  "summary": "Resumo",
  "content": "Conteúdo",
  "category_id": 1
}
```

---

### Command Artisan
Atualiza o título de todas as postagens:
```bash
php artisan posts:update-title "Novo título"
```

---

### Estrutura e Boas Práticas
- Uso de Form Requests para validação de dados
- Policies para controle de autorização
- Paginação nas listagens
- Separação entre controllers da API e controllers web
- Uso de eager loading para evitar problemas de N+1
- Seeders para popular o banco de dados
- Rotas organizadas por middleware de autenticação