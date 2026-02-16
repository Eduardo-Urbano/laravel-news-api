@extends('layouts.app')

@section('content')

<h1 class="text-2xl mb-6">Nova Categoria</h1>

<div class="dark:bg-gray-800 shadow rounded p-6 max-w-xl">

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1">
                Nome
            </label>

            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name') }}"
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
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Salvar
            </button>
        </div>

    </form>

</div>

@endsection