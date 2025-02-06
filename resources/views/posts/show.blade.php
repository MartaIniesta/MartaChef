<h1>{{ $post->title }}</h1>
<p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>

{{-- Mostrar los comentarios --}}
<h3>Comentarios:</h3>
@if ($comments->count())
    <ul>
        @foreach ($comments as $comment)
            <x-comment :comment="$comment" />
        @endforeach
    </ul>
@else
    <p>No hay comentarios aún.</p>
@endif

<!-- Formulario para agregar un nuevo comentario -->
<form action="{{ route('comments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <textarea name="content" required placeholder="Escribe un comentario..."></textarea>
    <button type="submit">Comentar</button>
</form>

{{-- Categorias --}}
<h3>Categorías:</h3>
<ul>
    @foreach ($post->categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

{{-- Etiquetas --}}
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
