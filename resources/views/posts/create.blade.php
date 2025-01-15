<h1>Crear nueva receta</h1>

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required>
    </div>

    <div>
        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required>{{ old('description') }}</textarea>
    </div>

    <div>
        <label for="ingredients">Ingredientes:</label>
        <textarea name="ingredients" id="ingredients" required>{{ old('ingredients') }}</textarea>
    </div>

    <div>
        <label for="image">Imagen:</label>
        <input type="file" name="image" id="image" accept="image/*">
    </div>

    <div>
        <button type="submit">Crear Post</button>
    </div>
</form>

<a href="{{ route('posts.index') }}">< Volver</a>
