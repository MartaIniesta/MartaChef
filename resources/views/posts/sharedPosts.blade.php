<x-app-layout>
    <x-first-navigation-bar />

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-manage-link/>
                <x-nav.nav-blog-link/>
                <x-nav.nav-recipes-link/>
                <x-nav.nav-my-recipes-link/>
                <x-nav.nav-favorites-link/>
            </div>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9] mb-4">
        <div class="w-56 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{ __('SHARED RECIPES') }}
            </h1>
        </div>

        @if ($sharedPosts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
                @foreach ($sharedPosts as $post)
                    <div class="hover:bg-gray-100/75 border border-gray-300 p-4 rounded-lg shadow-md text-center">
                        <a href="{{ route('posts.show', $post) }}" class="text-inherit no-underline">
                            <h2 class="text-lg font-semibold mb-2">{{ $post->title }}</h2>
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-[80%] max-h-[200px] mx-auto rounded-md mt-2">
                            <p class="mt-2 text-gray-700">{{ $post->description }}</p>
                            <small class="text-gray-500">
                                By {{ $post->user->name }} | <x-date :date="$post->created_at" /> | {{ ucfirst($post->visibility) }}
                            </small>
                        </a>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $sharedPosts->links('vendor.pagination.pagination') }}
            </div>

        @else
            <p class="text-center text-gray-500">
                {{__('There are no shared posts from the people you follow.')}}
            </p>
        @endif
    </div>
</x-app-layout>
