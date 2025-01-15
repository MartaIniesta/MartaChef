<h1>Lista de Recetas</h1>
<a href="{{ route('home') }}">Home</a><br>
<a href="{{ route('posts.create') }}">Crear post</a>
@foreach ($posts as $post)
    <h2>
        <a style="text-decoration: none; color: inherit;" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
    </h2>
    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 250px;">
    <p>{{ $post->description }}</p>
@endforeach
