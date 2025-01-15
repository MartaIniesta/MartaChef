<h1>Lista de Posts</h1>
<a href="{{ route('home') }}">Inicio</a>
@foreach ($posts as $post)
    <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
    <p>{{ $post->description }}</p>
@endforeach
