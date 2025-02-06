<h1>Posts Compartidos</h1>

@if ($sharedPosts->count())
    @foreach ($sharedPosts as $post)
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; border-radius: 8px; padding: 15px;">
            <h2>
                <a style="text-decoration: none; color: inherit;" href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>

            @if ($post->image && file_exists(public_path('storage/' . $post->image)))
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
            @else
                <p><i>Imagen no disponible</i></p>
            @endif

            <p>{{ $post->description }}</p>
            <small>By {{ $post->user->name ?? 'Autor desconocido' }} | {{ $post->created_at->format('d M Y') }}</small>
        </div>
    @endforeach

    <!-- Paginación -->
    <div style="margin-top: 20px;">
        {{ $sharedPosts->links() }}
    </div>
@else
    <p>No hay posts compartidos de las personas que sigues.</p>
@endif

<a href="{{ route('posts.index') }}">Volver</a>
