<h1>Mis Posts</h1>

@if ($userPosts->count())
    @foreach ($userPosts as $post)
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
            <h2>
                <a style="text-decoration: none; color: inherit;" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
            <p>{{ $post->description }}</p>
            <small>By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}</small>
        </div>
    @endforeach
@else
    <p>No tienes posts aún.</p>
@endif
<a href="{{ route('posts.index') }}">< Volver</a>
