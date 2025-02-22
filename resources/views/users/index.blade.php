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
        <div class="w-44 mx-auto mt-1">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('BLOG USERS')}}
            </h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                @if ($user->id !== auth()->id() && !$user->hasRole('admin') && !$user->hasRole('moderator'))
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 duration-300">
                        <div class="p-6 flex flex-col items-center text-center">
                            <!-- Imagen de perfil -->
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-images/default-profile.png') }}"
                                 alt="{{ $user->name }}"
                                 class="w-24 h-24 rounded-full shadow-md mb-4 object-cover">

                            <h2 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h2>

                            <p class="text-gray-500 text-sm">{{ $user->email }}</p>

                            <div class="mt-4">
                                <a href="{{ route('users.show', $user) }}"
                                   class="inline-block bg-[#B6D5E9] px-4 py-2 rounded-lg hover:bg-[#5C99C1] transition duration-300 shadow-md">
                                    {{__('View profile')}}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            {{ $users->links('vendor.pagination.pagination') }}
        </div>

        <x-footer />
    </div>
</x-app-layout>
