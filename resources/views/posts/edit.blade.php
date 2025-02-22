<x-app-layout>
    <x-first-navigation-bar/>

    <nav>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                @auth
                    <a href="{{ route('posts.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/blog.png') }}" class="h-12 w-12">
                        </div>
                        {{ __('BLOG') }}
                    </a>

                    <a href="{{ route('posts.recipes') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/recipes.png') }}" class="h-12 w-12">
                        </div>
                        {{ __('RECIPES') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <a href="{{ route('posts.show', $post) }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
        < {{ __('Return') }}
    </a>

    <div class="mt-5 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-4xl mx-auto">
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('Edit Recipe')}}
                </h1>
            </div>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
                @csrf
                @method('PUT')

                {{-- Buscador de categorías --}}
                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-medium">
                        {{__('Categories')}}:
                    </label>
                    <input type="text" id="category-search" placeholder="Buscar categoría..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Selector de categorías --}}
                <div class="mb-6">
                    <label for="categories" class="block text-gray-700 font-medium">
                        {{__('Categories')}}:
                    </label>
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
                    <button type="button" id="add-category-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{__('Add Category')}}
                    </button>
                </div>

                <div id="selected-categories" class="mb-6"
                     data-categories="{{ json_encode($selectedCategories ?? []) }}">
                    <!-- Las categorías seleccionadas se irán añadiendo aquí -->
                </div>

                {{-- Título --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">
                        {{__('Title')}}:
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">
                        {{__('Description')}}:
                    </label>
                    <textarea name="description" id="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $post->description ?? '') }}</textarea>
                </div>

                {{-- Ingredientes --}}
                <div class="mb-4">
                    <label for="ingredients" class="block text-gray-700 font-medium">
                        {{__('Ingredients')}}:
                    </label>
                    <input
                        type="text"
                        name="ingredients"
                        placeholder="Indica los ingredientes separados por comas"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('ingredients', $post->ingredients) }}"
                    >
                </div>

                {{-- Etiquetas --}}
                <div class="mb-4">
                    <label for="tags" class="block text-gray-700 font-medium">
                        {{__('Tags')}}:
                    </label>
                    <input type="text" name="tags" id="tags" placeholder="#rico #facil"
                           value="{{ old('tags', $post->tags->pluck('name')->implode(' ')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Visibilidad --}}
                <div class="mb-4">
                    <label for="visibility" class="block text-gray-700 font-medium">
                        {{__('Visibility')}}:
                    </label>
                    <select name="visibility" id="visibility" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="public" {{ old('visibility', $post->visibility ?? '') == 'public' ? 'selected' : '' }}>
                            {{__('Public')}}
                        </option>
                        <option value="private" {{ old('visibility', $post->visibility ?? '') == 'private' ? 'selected' : '' }}>
                            {{__('Private')}}
                        </option>
                        <option value="shared" {{ old('visibility', $post->visibility ?? '') == 'shared' ? 'selected' : '' }}>
                            {{__('Shared')}}
                        </option>
                    </select>
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium">
                        {{__('Image')}}:
                    </label>

                    <!-- Contenedor de la vista previa -->
                    <div id="imagePreview" class="flex justify-center">
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
        </div>

        <x-footer/>
    </div>

    {{-- Scripts específicos para esta vista --}}
    @push('scripts')
        <script src="{{ asset('js/category-select-edit.js') }}" defer></script>
        <script src="{{ asset('js/category-search.js') }}" defer></script>
        <script src="{{ asset('js/image-preview.js') }}" defer></script>
    @endpush
</x-app-layout>
