@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 text-center dark:text-gray-100">
            Bem-vindo ao seu painel!
        </div>

    <!--Botões de ações rápidas-->
        <div class="w-full flex justify-center">
            <div class="flex flex-row gap-4 justify-center-center">
                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 hover:bg-black text-center text-white px-4 py-2 rounded">
                    Criar Postagem
                </a>
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 hover:bg-black text-center text-white px-4 py-2 rounded">
                    Criar Categoria
                </a>
            </div>
        </div>

        <!-- Postagens -->
        <div class="bg-white dark:bg-gray-800 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Últimas postagens</h3>

            <ul>
                @forelse ($posts as $post)
                    <li class="border-b py-2 flex justify-between items-center">
                        <span>{{ $post->title }}</span>

                        <div class="flex space-x-2 gap-2">
                            <a href="{{ route('posts.edit', $post->id) }}"
                               class="text-blue-500 hover:underline">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}"
                                onsubmit="return confirm('Tem certeza que deseja excluir este post?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" type="submit">Deletar</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Nenhuma postagem encontrada.</li>
                @endforelse
            </ul>
        </div>

        <!-- Categorias -->
        <div class="bg-white dark:bg-gray-800 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Categorias</h3>

            <ul>
                @forelse ($categories as $category)
                    <li class="border-b py-2 flex justify-between items-center">
                        <span>{{ $category->name }} ({{ $category->posts_count }} posts)</span>

                        <div class="flex space-x-2 gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="text-blue-500 hover:underline">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}"
                                onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" type="submit">Deletar</button>
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