<x-app-layout>
    <nav class="bg-[#F8F8F8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-12">
                <!-- Logo -->
                <div class="absolute ml-14 top-0.5 transform -translate-x-1/2 bg-[#B6D5E9]
                        h-[170px] hover:h-[200px] w-[90px] transition-all duration-300
                        flex justify-center items-end pb-1 overflow-hidden shadow-md rounded-b-2xl">
                    <x-application-logo/>
                </div>

                <!-- Autenticación (Menú desplegable) -->
                <div class="flex items-center space-x-6 ml-auto relative group">
                    @guest
                        <!-- Cuenta (Menú desplegable) -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="text-gray-800 hover:text-gray-600 focus:outline-none text-sm flex items-center space-x-1">
                                    <img src="{{ asset('storage/icons/agregar-usuario.png') }}" class="h-5 w-5">
                                    <span class="mt-1">CUENTA</span>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('login')" class="rounded-t-md">
                                    {{ __('Login') }}
                                </x-dropdown-link>
                                <hr class="border-gray-300 mx-2">
                                <x-dropdown-link :href="route('register')" class="rounded-b-md">
                                    {{ __('Register') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endguest
                    @auth
                        <x-dropdown align="right" width="48" closeOnItemClick="true">
                            <x-slot name="trigger">
                                <button class="focus:outline-none">
                                    <img
                                        src="{{ Auth::user()->profile_image ? asset('storage/public' . Auth::user()->profile_image) : asset('default-images/default-profile.png') }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="h-12 w-12 mt-1.5"
                                    >
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-t-md">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <hr class="border-gray-300 mx-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault(); this.closest('form').submit();"
                                                     class="rounded-b-md">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <nav class="bg-[#F0F0F0] p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo / Home -->
            <a href="{{ route('home') }}" class="text-xl">
                < Inicio
            </a>

            <!-- Menú de navegación -->
            <div class="space-x-4">
                @auth
                    <a href="{{ route('posts.myPosts') }}">
                        Mis Recetas
                    </a>
                    <a href="{{ route('posts.shared') }}">
                        Recetas Compartidas
                    </a>
                    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600">
                        Crear Receta
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <h1 class="text-2xl font-bold text-center mb-6 mt-5">Blog</h1>

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

    <!-- Pie de Página -->
    <x-footer></x-footer>
</x-app-layout>
