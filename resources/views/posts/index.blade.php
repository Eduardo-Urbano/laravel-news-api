@extends('layouts.app')

@section('content')

<h1 class="text-2xl mb-4 text-white">Posts</h1>

<div class="mb-4">
    <a href="{{ route('posts.create') }}"
       class="bg-blue-600 hover:bg-black text-white px-4 py-2 rounded">
        Novo Post
    </a>
</div>

@if(isset($posts) && $posts->count())
    <table class="w-full text-left bg-white dark:bg-gray-800 shadow rounded">
        <thead>
            <tr class="border-b text-white">
                <th class="p-2">Título</th>
                <th class="p-2">Categoria</th>
                <th class="p-2">Autor</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr class="border-b text-center">
                    <td class="p-2 text-white">
                        {{ $post->title }}
                    </td>

                    <td class="p-2 text-white">
                        {{ $post->category->name ?? '—' }}
                    </td>

                    <td class="p-2 text-white">
                        {{ $post->user->name ?? '—' }}
                    </td>

                    <td class="p-2 flex flex-row space-x-2 justify-center gap-3">
                        <a href="{{ route('posts.show', $post->id) }}"
                           class="text-blue-500 hover:underline">
                            Ver
                        </a>

                        <a href="{{ route('posts.edit', $post->id) }}"
                           class="text-white hover:underline">
                            Editar
                        </a>

                        <form action="{{ route('posts.destroy', $post->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir este post?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-600 hover:underline">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@else
    <p>Nenhum post encontrado.</p>
@endif

@endsection