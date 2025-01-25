<x-app-layout>
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Parte izquierda -->
                <div class="flex items-center">
                    <!-- Blog Link -->
                    <a href="{{ route('posts.index') }}" class="text-gray-800 hover:text-gray-600 transition duration-200 font-semibold text-lg">
                        Blog
                    </a>
                </div>

                <!-- Parte derecha -->
                <div class="flex items-center space-x-6">
                    @guest
                        <!-- Login & Register Links for Guests -->
                        <a href="{{ route('login') }}" class="text-gray-800 hover:text-gray-600 transition duration-200">
                            Login/
                        </a>
                        <a href="{{ route('register') }}" class="text-gray-800 hover:text-gray-600 transition duration-200">
                            Register
                        </a>
                    @endguest

                    @auth
                        <x-dropdown align="right" width="48" closeOnItemClick="true">
                            <!-- Trigger -->
                            <x-slot name="trigger">
                                <button class="focus:outline-none">
                                    <img
                                        src="{{ Auth::user()->profile_image ? asset('storage/public' . Auth::user()->profile_image) : asset('default-images/default-profile.png') }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="h-12 w-12 rounded-full object-cover hover:scale-105 transition duration-200"
                                    >
                                </button>
                            </x-slot>

                            <!-- Contenido -->
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                     this.closest('form').submit();">
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
</x-app-layout>
