<h1>Blog</h1>
<a href="{{ route('home') }}">Home</a><br>
@auth
    <a href="{{ route('posts.myPosts') }}">Mis recetas</a>
    <a href="{{ route('posts.create') }}">Crear receta</a>
@endauth

@foreach ($publicPosts as $post)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
        <h2>
            <a style="text-decoration: none; color: inherit;" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
        </h2>
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 250px;">
        <p>{{ $post->description }}</p>
        <small>By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}</small>
    </div>
@endforeach
