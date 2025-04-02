<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-users-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-recipes-link/>
        </div>
    </div>

    <div class="mt-5 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-2">
                        {{__('Email')}}: {{ $user->email }}
                    </p>
                </div>

                @auth
                    <!-- No muestra su propio perfil, ni de admins ni moderadores -->
                    @if($user->id !== auth()->id() && !$user->hasRole('admin') && !$user->hasRole('moderator'))
                        <div class="mt-4">
                            @if(auth()->user()->isFollowing($user))
                                <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                                        {{__('Unfollow')}}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                                        {{__('Follow')}}
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
                <p class="text-center text-gray-500">
                    {{__('This user has no published recipes.')}}
                </p>
            @endif
        </div>

        <div class="mt-4">
            {{ $posts->links('vendor.pagination.pagination') }}
        </div>
    </div>
</x-app-layout>
