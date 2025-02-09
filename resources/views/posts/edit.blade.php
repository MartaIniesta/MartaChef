<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-semibold mb-6 text-center">Editar Receta</h1>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
                @csrf
                @method('PUT')

                {{-- Buscador de categorías --}}
                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-medium">Categorías:</label>
                    <input type="text" id="category-search" placeholder="Buscar categoría..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Selector de categorías --}}
                <div class="mb-6">
                    <label for="categories" class="block text-gray-700 font-medium">Categorías:</label>
                    <select name="categories[]" id="categories" multiple class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $selectedCategories ?? [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón de añadir categoría --}}
                <div class="mb-4">
                    <button type="button" id="add-category-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Añadir Categoría</button>
                </div>

                <div id="selected-categories" class="mb-6"
                     data-categories="{{ json_encode($selectedCategories ?? []) }}">
                    <!-- Las categorías seleccionadas se irán añadiendo aquí -->
                </div>

                {{-- Título --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">Título:</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Descripción:</label>
                    <textarea name="description" id="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $post->description ?? '') }}</textarea>
                </div>

                {{-- Ingredientes --}}
                <div class="mb-4">
                    <label for="ingredients" class="block text-gray-700 font-medium">Ingredientes:</label>
                    <input
                        type="text"
                        name="ingredients"
                        placeholder="Indica los ingredientes separados por comas"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('ingredients', $post->ingredients) }}"
                    >
                </div>

                {{-- Visibilidad --}}
                <div class="mb-4">
                    <label for="visibility" class="block text-gray-700 font-medium">Visibilidad:</label>
                    <select name="visibility" id="visibility" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="public" {{ old('visibility', $post->visibility ?? '') == 'public' ? 'selected' : '' }}>Público</option>
                        <option value="private" {{ old('visibility', $post->visibility ?? '') == 'private' ? 'selected' : '' }}>Privado</option>
                        <option value="shared" {{ old('visibility', $post->visibility ?? '') == 'shared' ? 'selected' : '' }}>Compartido</option>
                    </select>
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium">Imagen:</label>

                    <!-- Contenedor de la vista previa -->
                    <div id="imagePreview">
                        @if(isset($post) && $post->image)
                            <div class="mb-2 flex justify-center">
                                <img id="currentImage" src="{{ asset('storage/' . $post->image) }}"
                                     alt="Imagen actual" class="w-32 h-32 object-cover rounded-md border">
                            </div>
                        @endif
                    </div>

                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Mostrar errores --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Actualizar Receta</button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline">&lt; Volver</a>
            </div>
        </div>
    </div>

    {{-- Scripts específicos para esta vista --}}
    @push('scripts')
        <script src="{{ asset('js/category-select-edit.js') }}" defer></script>
        <script src="{{ asset('js/category-search.js') }}" defer></script>
        <script src="{{ asset('js/image-preview.js') }}" defer></script>
    @endpush
</x-app-layout>
