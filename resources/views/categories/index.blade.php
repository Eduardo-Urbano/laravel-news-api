@extends('layouts.app')

@section('content')

<h1 class="text-2xl mb-4">Categorias</h1>

<div class="mb-4">
    <a href="{{ route('categories.create') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
        Nova Categoria
    </a>
</div>

@if(isset($categories) && $categories->count())
    <table class="w-full text-left bg-white dark:bg-gray-800 shadow rounded">
        <thead>
            <tr class="border-b">
                <th class="p-2">Nome</th>
                <th class="p-2">Quantidade de Posts</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="border-b">
                    <td class="p-2">
                        {{ $category->name }}
                    </td>

                    <td class="p-2">
                        {{ $category->posts_count ?? $category->posts->count() }}
                    </td>

                    <td class="p-2 space-x-2">
                        <a href="{{ route('categories.show', $category->id) }}"
                           class="text-blue-500 hover:underline">
                            Ver
                        </a>

                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="text-yellow-500 hover:underline">
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@else
    <p>Nenhuma categoria encontrada.</p>
@endif

@endsection