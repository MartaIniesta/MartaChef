<x-app-layout>
    <x-first-navigation-bar/>

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-manage-link/>
                <x-nav.nav-blog-link/>
                <x-nav.nav-recipes-link/>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <a href="{{ url()->previous() }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
            < {{ __('Return') }}
        </a>
    </div>

    <div class="mt-1 mb-4 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-4xl mx-auto">
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('Edit Recipe')}}
                </h1>
            </div>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-medium">
                        {{__('Categories')}}:
                    </label>
                    <input type="text" id="category-search" placeholder="Buscar categoría..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

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

                <div class="mb-4">
                    <button type="button" id="add-category-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{__('Add Category')}}
                    </button>
                </div>

                <div id="selected-categories" class="mb-6"
                     data-categories="{{ json_encode($selectedCategories ?? []) }}">
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">
                        {{__('Title')}}:
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">
                        {{__('Description')}}:
                    </label>
                    <textarea name="description" id="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $post->description ?? '') }}</textarea>
                </div>

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

                <div class="mb-4">
                    <label for="tags" class="block text-gray-700 font-medium">
                        {{__('Tags')}}:
                    </label>
                    <input type="text" name="tags" id="tags" placeholder="#rico #facil"
                           value="{{ old('tags', $post->tags->pluck('name')->implode(' ')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

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

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium">
                        {{__('Image')}}:
                    </label>

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

                <x-global-errors/>

                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Actualizar Receta</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/category-select-edit.js') }}" defer></script>
        <script src="{{ asset('js/category-search.js') }}" defer></script>
        <script src="{{ asset('js/image-preview.js') }}" defer></script>
    @endpush
</x-app-layout>
