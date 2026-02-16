@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Boas-vindas -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            Bem-vindo ao seu painel!
        </div>

        <!-- Ações rápidas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('posts.create') }}"
               class="bg-blue-500 text-white p-4 rounded hover:bg-blue-600 text-center">
                Criar Postagem
            </a>

            <a href="{{ route('categories.create') }}"
               class="bg-green-500 text-white p-4 rounded hover:bg-green-600 text-center">
                Criar Categoria
            </a>
        </div>

        <!-- Últimas postagens -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Últimas postagens</h3>

            <ul>
                @forelse ($posts as $post)
                    <li class="border-b py-2 flex justify-between items-center">
                        <span>{{ $post->title }}</span>

                        <div class="flex space-x-2">
                            <a href="{{ route('posts.edit', $post->id) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Deletar
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Nenhuma postagem encontrada.</li>
                @endforelse
            </ul>
        </div>

        <!-- Categorias -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Categorias</h3>

            <ul>
                @forelse ($categories as $category)
                    <li class="border-b py-2 flex justify-between items-center">
                        <span>{{ $category->name }} ({{ $category->posts_count }} posts)</span>

                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Tem certeza?')">
                                    Deletar
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Nenhuma categoria cadastrada.</li>
                @endforelse
            </ul>
        </div>

    </div>
</div>
@endsection