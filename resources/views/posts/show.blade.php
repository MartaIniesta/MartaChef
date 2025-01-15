<h1>{{ $post->title }}</h1>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>
<a href="{{ route('posts.edit', $post) }}">Editar receta</a><br>
<a href="{{ route('posts.index') }}">< Volver</a>
