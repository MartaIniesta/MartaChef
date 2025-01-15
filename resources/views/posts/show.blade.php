<h1>{{ $post->title }}</h1>
<p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>

@auth
    <a href="{{ route('posts.edit', $post) }}">Editar receta</a><br>
@endauth

<a href="{{ route('posts.index') }}">< Volver</a>
