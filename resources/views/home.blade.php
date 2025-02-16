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

                <div class="flex justify-center items-center ml-[195px]">
                    <img src="{{ asset('storage/icons/prueba2.png') }}" class="h-[75px] mt-16">
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

    <nav class="bg-[#F0F0F0]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Segunda Parte del Menú -->
                <div class="flex justify-center items-center space-x-8 ml-auto mt-10 pb-3 bg-[#F0F0F0] w-[200px] rounded-full">
                    <a href="{{ route('posts.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <!-- Cuadrado blanco con imagen -->
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/blog.png') }}" class="h-12 w-12">
                        </div>
                        BLOG
                    </a>

                    <a href="#" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        <!-- Cuadrado blanco con imagen -->
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                            <img src="{{ asset('storage/icons/recetas.png') }}" class="h-12 w-12">
                        </div>
                        RECETAS
                    </a>
                </div>
            </div>
        </div>
    </nav>
</x-app-layout>
