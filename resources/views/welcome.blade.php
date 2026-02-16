@extends('layouts.app')

@section('content')
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
@endsection