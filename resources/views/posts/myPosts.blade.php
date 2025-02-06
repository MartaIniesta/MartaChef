<h1>Mis Posts</h1>

<!-- Menú de selección de visibilidad -->
<form method="GET" action="{{ route('posts.myPosts') }}">
    <label for="visibility">Filtrar por visibilidad:</label>
    <select name="visibility" id="visibility" onchange="this.form.submit()">
        <option value="all" {{ request('visibility') == 'all' ? 'selected' : '' }}>Todos</option>
        <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Públicos</option>
        <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privados</option>
        <option value="shared" {{ request('visibility') == 'shared' ? 'selected' : '' }}>Compartidos</option>
    </select>
</form>

<!-- Mostrar los posts filtrados -->
@if ($userPosts->count())
    @foreach ($userPosts as $post)
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
            <h2>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <p><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 300px;">
            <p>{{ $post->description }}</p>
            <small>By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }} | {{ $post->visibility }}</small>
        </div>
    @endforeach
@else
    <p>No tienes posts en esta categoría.</p>
@endif

<a href="{{ route('posts.index') }}">Volver</a>
