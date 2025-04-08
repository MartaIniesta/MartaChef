<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-moderate-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-users-link/>
            @auth
                <x-nav.nav-my-recipes-link/>
                <x-nav.nav-favorites-link/>
                <x-nav.nav-shared-recipes-link/>
            @endauth
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-36 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('RECIPES')}}
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

        <div>
            {{ $publicPosts->links('vendor.pagination.pagination') }}
        </div>
    </div>
</x-app-layout>
