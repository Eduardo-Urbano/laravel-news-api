<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categorias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Lista de Categorias</h3>
                    <a href="{{ route('categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Nova Categoria
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 p-2 text-left">ID</th>
                            <th class="border-b-2 p-2 text-left">Nome</th>
                            <th class="border-b-2 p-2 text-left">Total Posts</th>
                            <th class="border-b-2 p-2 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="border-b p-2">{{ $category->id }}</td>
                            <td class="border-b p-2">{{ $category->name }}</td>
                            <td class="border-b p-2">{{ $category->posts->count() }}</td>
                            <td class="border-b p-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
                                
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza?')">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">Nenhuma categoria encontrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>