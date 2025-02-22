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
                            {{__('MANAGE')}}
                        </a>
                    @endif
                @endauth

                <a href="{{ route('posts.recipes') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/recipes.png') }}" class="h-12 w-12">
                    </div>
                    {{ __('RECIPES') }}
                </a>

                <a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/users.png') }}" class="h-12 w-12">
                    </div>
                    {{__('USERS')}}
                </a>
            </div>
        </div>
    </nav>

    <div class="mt-5 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-36 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                BLOG
            </h1>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="flex items-center my-8">
                <div class="flex-grow border-t border-gray-300"></div>
                <h2 class="mx-7 px-7 py-3 border border-gray-400 font-semibold uppercase tracking-wide">
                    {{__('THE')}} + {{__('NEW')}}
                </h2>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($latestPosts as $post)
                    <div class="border border-gray-300 p-4 text-center rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('posts.show', $post) }}" class="text-inherit no-underline">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="{{ $post->title }}"
                             class="max-w-[80%] max-h-[200px] mx-auto rounded-md">
                        <p class="mt-2 text-gray-700">{{ $post->description }}</p>
                        <small class="text-gray-500">
                            By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}
                        </small>
                    </div>
                @endforeach
            </div>

            <!-- Posts por categoría -->
            <div class="flex items-center my-8">
                <div class="flex-grow border-t border-gray-300"></div>
                <h2 class="mx-7 px-7 py-3 border border-gray-400 font-semibold uppercase tracking-wide">
                    {{__('RECIPES')}} x {{__('CATEGORY')}}
                </h2>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
                @foreach ($categoryPosts as $categoryName => $post)
                    <div class="border border-gray-300 p-4 text-center rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold">
                            <a href="{{ route('posts.show', $post) }}" class="text-inherit no-underline">
                                {{ $post->title }} ({{ $categoryName }})
                            </a>
                        </h2>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-[80%] max-h-[200px] mx-auto rounded-md">
                        <p class="mt-2 text-gray-700">{{ $post->description }}</p>
                        <small class="text-gray-500">By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}</small>
                    </div>
                @endforeach
            </div>

            <!-- Top 3 Usuarios -->
            <div class="flex items-center my-8">
                <div class="flex-grow border-t border-gray-300"></div>
                <h2 class="mx-7 px-7 py-3 border border-gray-400 font-semibold uppercase tracking-wide">
                    {{__('OUR BEST USERS')}}
                </h2>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
                @foreach ($topUsers as $user)
                    <div class="border border-gray-300 p-4 text-center rounded-lg shadow-md">
                        <a href="{{ route('users.show', $user) }}">
                            <img src="{{ $user->profile_image ? asset('storage/public' . $user->profile_image) : asset('default-images/default-profile.png') }}" alt="{{ $user->name }}" class="h-16 w-16 mx-auto rounded-full">
                            <h2 class="text-lg font-semibold mt-2">
                                {{ $user->name }}
                            </h2>
                        </a>
                        <p class="text-gray-700">
                            {{__('Followers')}}: {{ $user->followers_count }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <x-footer />
    </div>
</x-app-layout>
