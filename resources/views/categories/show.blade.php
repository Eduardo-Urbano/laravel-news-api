@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ $category->name }}
            </h2>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <p class="text-gray-700 dark:text-gray-300">
                Criada em {{ $category->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="mt-4">
            <a href="{{ route('categories.index') }}"
               class="text-blue-500 hover:underline">
                Voltar
            </a>
        </div>

    </div>
</div>
@endsection