# Laravel News API

API REST desenvolvida em Laravel para gerenciamento de usuários, categorias e postagens de notícias, com autenticação via Sanctum.

## 🚀 Tecnologias utilizadas

- PHP 8.2
- Laravel
- Laravel Sanctum
- SQLite

## 📌 Funcionalidades

- Cadastro e login de usuários
- Autenticação via Bearer Token
- CRUD de categorias
- CRUD de postagens
- Paginação e filtros
- Policies para controle de autorização
- Command Artisan para atualização de títulos

## ⚙️ Instalação

```bash
git clone <url-do-repositorio>
cd laravel-news-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve