<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Muestra: Titulo, autor, imagen y descripcion -->
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        <p class="text-gray-600 mb-4"><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="mb-4 max-w-md mx-auto">
        <p class="mb-6">{{ $post->description }}</p>

        <!-- Muestra INGREDIENTES -->
        @auth
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Ingredientes:</h3>
                <ul class="list-disc ml-6">
                    @foreach(array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
            </div>
        @endauth

        <!-- Muestra CATEGORIAS -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Categorías:</h3>
            <ul class="list-disc ml-6">
                @foreach ($post->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Muestra ETIQUETAS -->
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

        @auth
            @if(auth()->user()->id === $post->user_id || auth()->user()->hasRole('moderator') || auth()->user()->hasRole('admin'))
                <!-- Boton EDITAR -->
                @can('edit-posts', $post)
                    <div class="mb-6">
                        <button onclick="window.location='{{ route('posts.edit', $post) }}'" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2">
                            Editar receta
                        </button>
                    </div>
                @endcan

                <!-- Boton ELIMINAR -->
                @can('delete-posts', $post)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </form>
                @endcan
            @endif

            <!-- Muestra las OPINIONES ⭐ -->
            @can('rate-posts')
                    <h3 class="text-xl font-semibold mb-2">Opiniones de clientes</h3>
                    <livewire:post-rating :post="$post"/>
            @endcan

            <!-- Muestra COMENTARIOS -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Comentarios:</h3>
                @if ($comments->count())
                    <ul class="space-y-4">
                        @foreach ($comments as $comment)
                            <x-comment :comment="$comment" />
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">¡Sé el primero en comentar!</p>
                @endif
            </div>
        @endauth


        <!-- Añadir COMENTARIO -->
        @can('create-comments')
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
        @else
            <p class="text-gray-500 text-center mt-6">
                <a href="{{ route('login') }}"><strong>Inicia sesión para ver la receta completa.</strong></a>
            </p>
        @endcan

        <a href="{{ route('posts.index') }}" class="inline-block mt-4 text-blue-500 hover:underline">&lt; Volver</a>
    </div>

    <!-- Pie de pagina -->
    <x-footer></x-footer>
</x-app-layout>
