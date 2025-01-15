<h1>{{ $post->title }}</h1>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>
<a href="{{ route('posts.index') }}">Volver a la lista</a>
