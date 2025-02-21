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

                <a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/users.png') }}" class="h-12 w-12">
                    </div>
                    USUARIOS
                </a>

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
            </div>
        </div>
    </nav>

    <div class="mt-5 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-2">Email: {{ $user->email }}</p>
                </div>

                @auth
                    @if(auth()->id() !== $user->id)
                        <div class="mt-4">
                            @if(auth()->user()->following->contains($user))
                                <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                                        Unfollow
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                                        Follow
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <div class="mt-8">
            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto">
                    @foreach ($posts as $post)
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
            @else
                <p class="text-center text-gray-500">This user has no published recipes.</p>
            @endif
        </div>

        <div class="mt-4">
            {{ $posts->links('vendor.pagination.pagination') }}
        </div>

        <x-footer/>
    </div>
</x-app-layout>
