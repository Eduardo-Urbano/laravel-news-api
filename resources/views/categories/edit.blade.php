@extends('layouts.app')

@section('content')

<h1 class="text-2xl mb-6">Editar Categoria</h1>

<div class="bg-white shadow rounded p-6 max-w-xl">

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1">
                Nome
            </label>

            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $category->name) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

            @error('name')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('categories.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Cancelar
            </a>

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Atualizar
            </button>
        </div>

    </form>

</div>

@endsection