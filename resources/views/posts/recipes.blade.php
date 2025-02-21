<x-app-layout>
    <x-first-navigation-bar />

    <nav>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                            <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                                <img src="{{ asset('storage/icons/administrar.png') }}" class="h-12 w-12">
                            </div>
                            ADMINISTRAR
                        </a>
                    @endif
                @endauth

                <a href="{{ route('posts.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/blog.png') }}" class="h-12 w-12">
                    </div>
                    {{ __('BLOG') }}
                </a>

                <a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/users.png') }}" class="h-12 w-12">
                    </div>
                    USUARIOS
                </a>

                @auth
                    <a href="{{ route('posts.myPosts') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/myRecipes.png') }}" class="h-12 w-12">
                        </div>
                        MY RECIPES
                    </a>

                    <a href="{{ route('posts.shared') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/sharedRecipes.png') }}" class="h-12 w-12">
                        </div>
                        RECETAS COMPARTIDAS
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="mt-5 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-36 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                RECETAS
            </h1>
        </div>

        @auth
            <div class="flex justify-center -mt-2 mb-4">
                <a href="{{ route('posts.create') }}"
                   class="bg-[#B6D5E9] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full
               hover:bg-[#5C99C1] transition-transform duration-500 hover:rotate-180">
                    +
                </a>
            </div>
        @endauth

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
            @foreach ($publicPosts as $post)
                <div class="border border-gray-300 p-4 text-center rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">
                        <a href="{{ route('posts.show', $post) }}" class="text-inherit no-underline">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-[80%] max-h-[200px] mx-auto rounded-md">
                    <p class="mt-2 text-gray-700">{{ $post->description }}</p>
                    <small class="text-gray-500">
                        By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}
                    </small>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div>
            {{ $publicPosts->links('vendor.pagination.pagination') }}
        </div>

        <x-footer />
    </div>
</x-app-layout>
