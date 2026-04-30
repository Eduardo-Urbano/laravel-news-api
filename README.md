# 📰 NewsFlow API

Aplicação full stack desenvolvida em Laravel com foco em gerenciamento de notícias, autenticação de usuários e organização de conteúdo por categorias.

O projeto combina uma **API REST autenticada**, documentação profissional com **Swagger/OpenAPI**, interface web administrativa com **Blade**, além de deploy em produção com Docker + Render.

---

# Deploy em Produção

### Aplicação:
https://newsflowapi.onrender.com

### Swagger / Documentação da API:
https://newsflowapi.onrender.com/api/documentation

### Health Check:
https://newsflowapi.onrender.com/health

---

## Tecnologias Utilizadas

- PHP 8.2
- Laravel 10+
- Laravel Sanctum
- SQLite
- Blade
- Swagger / OpenAPI (L5 Swagger)
- Docker
- Apache
- Render

---

## Visão Geral

O sistema foi estruturado com separação clara entre:

### API REST
- Registro de usuários
- Login com Bearer Token
- Logout
- CRUD de categorias
- CRUD de posts
- Paginação
- Filtros
- Policies (autorização por autor)

### Interface Web
- Login e autenticação
- Dashboard administrativo
- CRUD de posts
- CRUD de categorias
- Perfil de usuário
- Recuperação de senha
- Verificação de email

---

## Autenticação

A API utiliza Laravel Sanctum com Bearer Token.

### Registro:
```http
POST /api/register
