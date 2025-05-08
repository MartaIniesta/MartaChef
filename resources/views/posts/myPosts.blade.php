<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-users-link/>
            <x-nav.nav-recipes-link/>
            <x-nav.nav-favorites-link/>
            <x-nav.nav-shared-recipes-link/>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-48 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('MY RECIPES')}}
            </h1>
        </div>

        <div class="flex justify-center -mt-2 mb-4">
            <a href="{{ route('posts.create') }}"
               class="bg-[#B6D5E9] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full
               hover:bg-[#5C99C1] transition-transform duration-500 hover:rotate-180">
                +
            </a>
        </div>

        <x-select
            label="Filter by visibility"
            name="visibility"
            :options="[
            'all' => 'All',
            'public' => 'Public',
            'private' => 'Private',
            'shared' => 'Shared',
            ]"
            :selected="request('visibility', 'all')"
            :submitOnChange="true"
        />

        @if ($userPosts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
                @foreach ($userPosts as $post)
                    <div class="border border-gray-300 p-4 rounded-lg shadow-md text-center">
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('posts.show', $post) }}" class="text-inherit no-underline">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-[80%] max-h-[200px] mx-auto rounded-md mt-2">
                        <p class="mt-2 text-gray-700">{{ $post->description }}</p>
                        <small class="text-gray-500">
                            By {{ $post->user->name }} | <x-date :date="$post->created_at" /> | {{ ucfirst($post->visibility) }}
                        </small>
                    </div>
                @endforeach
            </div>

            <div class="mb-4">
                {{ $userPosts->links('vendor.pagination.pagination') }}
            </div>

        @else
            <p class="text-center text-gray-500">
                {{__('You dont have your own recipes.')}}
            </p>
        @endif
    </div>
</x-app-layout>
