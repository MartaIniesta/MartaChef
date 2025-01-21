<h1>{{ $post->title }}</h1>
<p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>

{{-- Mostrar los comentarios --}}
<h3>Comentarios:</h3>
@foreach ($post->comments as $comment)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
        <p><strong>Autor: {{ $comment->user->name }}</strong></p>
        <p>{{ $comment->content }}</p>

        <!-- Respuestas -->
        @if ($comment->replies->isNotEmpty())
            <div style="margin-left: 20px; border-left: 2px solid #ddd; padding-left: 10px;">
                <p><strong>Respuestas:</strong></p>
                @foreach ($comment->replies as $reply)
                    <p><strong>Autor: {{ $comment->user->name }}</strong></p>
                    <p>{{ $reply->content }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('comments.store') }}" method="POST" style="margin-top: 10px;">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" rows="2" placeholder="Escribe tu respuesta..." required></textarea>
            <br>
            <button type="submit">Responder</button>
        </form>
    </div>
@endforeach
<!-- Formulario para comentar directamente al post -->
<h3>Deja un comentario:</h3>
@if(Auth::check())
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <textarea name="content" rows="3" placeholder="Escribe un comentario..." required></textarea>
        <br>
        <button type="submit">Añadir comentario</button>
    </form>
@endif


<h3>Categorías:</h3>
<ul>
    @foreach ($post->categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

<h3>Etiquetas:</h3>
<ul>
    @foreach ($post->tags as $tag)
        <li>{{ $tag->name }}</li>
    @endforeach
</ul>

@auth
    <a href="{{ route('posts.edit', $post) }}">Editar receta</a><br>
@endauth

<!-- Botón de eliminar -->
<form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Eliminar</button>
</form>

<a href="{{ route('posts.index') }}">< Volver</a>
