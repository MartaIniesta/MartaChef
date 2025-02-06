<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Receta</title>
</head>
<body class="bg-gray-100 py-8">

<x-app-layout>
    <h1 class="text-3xl font-semibold mb-6 text-center">Crear nueva receta</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        @csrf

        {{-- Buscador de categorias --}}
        <div class="mb-4">
            <label for="categories" class="block text-gray-700 font-medium">Categorías:</label>
            <input type="text" id="category-search" placeholder="Buscar categoría..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Selector de categorias --}}
        <div class="mb-6">
            <select name="categories[]" id="categories" multiple class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botón de añadir categoría -->
        <div class="mb-4">
            <button type="button" id="add-category-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Añadir Categoría</button>
        </div>

        <!-- Categorías seleccionadas -->
        <div id="selected-categories" class="mb-6">
            <!-- Las categorías seleccionadas se irán añadiendo aquí -->
        </div>

        {{-- Título --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium">Título:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Descripción --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium">Descripción:</label>
            <textarea name="description" id="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </div>

        {{-- Ingredientes --}}
        <div class="mb-4">
            <label for="ingredients" class="block text-gray-700 font-medium">Ingredientes:</label>
            <textarea name="ingredients" id="ingredients" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('ingredients') }}</textarea>
        </div>

        {{-- Visibilidad --}}
        <div class="mb-4">
            <label for="visibility" class="block text-gray-700 font-medium">Visibilidad:</label>
            <select name="visibility" id="visibility" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="public">Público</option>
                <option value="private">Privado</option>
                <option value="shared">Compartido</option>
            </select>
        </div>

        {{-- Imagen --}}
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium">Imagen:</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Mostrar errores -->
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Crear Post</button>
    </form>

    <div class="text-center mt-6">
        <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline">&lt; Volver</a>
    </div>

    {{-- JS --}}
    <script src="{{ asset('js/category-select.js') }}"></script>
    <script src="{{ asset('js/category-search.js') }}"></script>
</x-app-layout>
</body>
</html>
