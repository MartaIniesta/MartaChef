<x-app-layout>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            @auth
                <x-nav.nav-blog-link/>
                <x-nav.nav-recipes-link/>
            @endauth
        </div>
    </div>

    <a href="{{ route('posts.recipes') }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
        < {{ __('Return') }}
    </a>

    <div class="mt-1 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-4xl mx-auto">
            <div class="w-64 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{ __('Create new recipe') }}
                </h1>
            </div>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
                @csrf

                {{-- Buscador de categorías --}}
                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-medium">
                        {{ __('Categories') }}:
                    </label>
                    <input type="text" id="category-search" placeholder="Buscar categoría..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Selector de categorías --}}
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
                    <button type="button" id="add-category-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{ __('Add Category') }}
                    </button>
                </div>

                <!-- Categorías seleccionadas -->
                <div id="selected-categories" class="mb-6">
                    <!-- Las categorías seleccionadas se irán añadiendo aquí -->
                </div>

                {{-- Título --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">
                        {{ __('Qualification') }}:
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">
                        {{ __('Description') }}:
                    </label>
                    <textarea name="description" id="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                {{-- Ingredientes --}}
                <div class="mb-4">
                    <label for="ingredients" class="block text-gray-700 font-medium">
                        {{ __('Ingredients') }}:
                    </label>
                    <input type="text" name="ingredients" placeholder="Indica los ingredientes separados por comas" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Etiquetas --}}
                <div class="mb-4">
                    <label for="tags" class="block text-gray-700 font-medium">
                        {{ __('Tags') }}:
                    </label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="#ricoyfacil #delicioso" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Visibilidad --}}
                <div class="mb-4">
                    <label for="visibility" class="block text-gray-700 font-medium">
                        {{ __('Visibility') }}:
                    </label>
                    <select name="visibility" id="visibility" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="public">{{ __('Public') }}</option>
                        <option value="private">{{ __('Private') }}</option>
                        <option value="shared">{{ __('Shared') }}</option>
                    </select>
                </div>

                {{-- Imagen --}}
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium">
                        {{ __('Image') }}:
                    </label>

                    <!-- Contenedor de la vista previa -->
                    <div id="imagePreview" class="mb-2 flex justify-center">
                        @if(isset($post) && $post->image)
                            <img id="currentImage" src="{{ asset('storage/' . $post->image) }}"
                                 alt="Imagen actual" class="w-32 h-32 object-cover rounded-md border">
                        @endif
                    </div>

                    <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Aceptación de términos y condiciones --}}
                <div class="mb-4 mt-1">
                    <p class="text-sm text-gray-700">
                        {{__('By creating a recipe on our platform, you guarantee that the content is original or that you have the rights to publish it. You agree not to share recipes that contain false, offensive, or inappropriate information. Furthermore, images must be your own or properly authorized for use. You agree that the platform reserves the right to remove any recipe that violates these terms or that is reported by other users.')}}
                    </p>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="terms" required class="mr-2">
                            {{ __('I accept the terms and conditions') }}
                        </label>
                    </div>
                </div>

                <x-global-errors/>

                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    {{ __('Create new recipe') }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/category-select-create.js') }}" defer></script>
        <script src="{{ asset('js/category-search.js') }}" defer></script>
        <script src="{{ asset('js/image-preview.js') }}" defer></script>
    @endpush
</x-app-layout>
