<x-app-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Usuarios del Blog</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                @if ($user->id !== auth()->id())
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>

                        <div class="mt-4">
                            <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:text-blue-700">
                                Ver perfil
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
