<h1>{{ $post->title }}</h1>
<p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
<p>{{ $post->description }}</p>
<p>Ingredientes: {{ $post->ingredients }}</p>

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

<a href="{{ route('posts.index') }}">< Volver</a>
