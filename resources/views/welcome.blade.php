<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Notícias</title>
</head>
<body>

<nav>
    @auth
        Olá, {{ auth()->user()->name }} |
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Cadastrar</a>
    @endauth
</nav>

<hr>

<h1>Lista de Postagens</h1>

{{-- Aqui depois entra a listagem --}}

</body>
</html>