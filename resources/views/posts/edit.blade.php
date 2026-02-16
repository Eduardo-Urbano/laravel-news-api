@extends('layouts.app')

@section('content')

<h1 class="text-2xl mb-6">Editar Postagem</h1>

<div class="dark:bg-gray-800 shadow rounded p-6 max-w-2xl">

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium mb-1">
                Título
            </label>

            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $post->title) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

            @error('title')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium mb-1">
                Conteúdo
            </label>

            <textarea name="content"
                      id="content"
                      rows="6"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('content', $post->content) }}</textarea>

            @error('content')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium mb-1">
                Categoria
            </label>

            <select name="category_id"
                    id="category_id"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

                <option value="">Selecione uma categoria</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('posts.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cancelar
            </a>

            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Atualizar
            </button>
        </div>

    </form>

</div>

@endsection