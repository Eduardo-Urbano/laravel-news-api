<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Lista de Posts</h3>
                    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Novo Post
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($posts as $post)
                    <div class="border-b py-4">
                        <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($post->content, 200) }}</p>
                        <p class="text-sm text-gray-500">Categoria: {{ $post->category->name ?? 'Sem categoria' }}</p>
                        
                        <div class="mt-2 space-x-2">
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza?')">
                                    Deletar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Nenhum post encontrado.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>