<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Título e información principal -->
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        <p class="text-gray-600 mb-4">
            <strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}
        </p>
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="mb-4 max-w-md mx-auto">
        <p class="mb-6">{{ $post->description }}</p>

        <!-- Ingredientes -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Ingredientes:</h3>
            <ul class="list-disc ml-6">
                @foreach(array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Categorías -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Categorías:</h3>
            <ul class="list-disc ml-6">
                @foreach ($post->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Etiquetas -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Etiquetas:</h3>
            @if($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Botones de editar/eliminar solo para el autor -->
        @auth
            @if(auth()->id() === $post->user_id)
                <div class="mb-6">
                    <button onclick="window.location='{{ route('posts.edit', $post) }}'" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2">
                        Editar receta
                    </button>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Calificación -->
        <h3 class="text-xl font-semibold mb-2">Opiniones de clientes</h3>
        <livewire:post-rating :post="$post"/>

        <!-- Comentarios -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Comentarios:</h3>
            @if ($comments->count())
                <ul class="space-y-4">
                    @foreach ($comments as $comment)
                        <x-comment :comment="$comment" />
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Se el primero en comentar!</p>
            @endif
        </div>

        <!-- Formulario para agregar un nuevo comentario -->
        <div class="mb-6">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="content" required placeholder="Escribe un comentario..." class="w-full border border-gray-300 rounded p-2 mb-2"></textarea>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Comentar
                </button>
            </form>
        </div>

        <!-- Volver a la lista de posts -->
        <a href="{{ route('posts.index') }}" class="inline-block mt-4 text-blue-500 hover:underline">&lt; Volver</a>
    </div>

    <!-- Pie de página -->
    <x-footer></x-footer>
</x-app-layout>
