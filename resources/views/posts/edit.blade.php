<h1>Editar Receta</h1>

<form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required>
    </div>

    <div>
        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required>{{ old('description', $post->description) }}</textarea>
    </div>

    <div>
        <label for="ingredients">Ingredientes:</label>
        <textarea name="ingredients" id="ingredients" required>{{ old('ingredients', $post->ingredients) }}</textarea>
    </div>

    <div>
        <label for="image">Imagen:</label>
        <input type="file" name="image" id="image" accept="image/*">
        @if ($post->image)
            <p>Imagen actual:</p>
            <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen de la receta" style="max-width: 300px;">
        @endif
    </div>

    <div>
        <button type="submit">Actualizar Post</button>
    </div>
</form>

<a href="{{ route('posts.index') }}">< Volver</a>
