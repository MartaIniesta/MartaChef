<x-app-layout>
    <x-first-navigation-bar/>

    <nav>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <a href="{{ route('posts.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/blog.png') }}" class="h-12 w-12">
                    </div>
                    {{ __('BLOG') }}
                </a>

                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/administrar.png') }}" class="h-12 w-12">
                    </div>
                    ADMINISTRAR
                </a>

                <a href="{{ route('admin.posts') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/administrar2.png') }}" class="h-12 w-12">
                    </div>
                    ADMINISTRAR RECETAS
                </a>
            </div>
        </div>
    </nav>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="container mx-auto mt-8">
            <div class="w-1/4 mx-auto pb-3">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    ADMINISTRAR USUARIOS
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">Nombre</th>
                    <th class="border p-3">Email</th>
                    <th class="border p-3">Estado</th>
                    <th class="border p-3">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="text-center">
                        <td class="border p-3">{{ $user->name }}</td>
                        <td class="border p-3">{{ $user->email }}</td>
                        <td class="border p-3">
                            @if ($user->trashed())
                                <span class="text-red-500 font-semibold">Eliminado</span>
                            @else
                                <span class="text-green-500 font-semibold">Activo</span>
                            @endif
                        </td>
                        <td class="border p-3 flex justify-center space-x-2">
                            @if ($user->trashed())
                                <!-- Botón para restaurar -->
                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Restaurar</button>
                                </form>

                                <!-- Botón para eliminar permanentemente -->
                                <form action="{{ route('admin.users.forceDelete', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar permanentemente este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">Borrar Definitivo</button>
                                </form>
                            @else
                                <!-- Botón para eliminar (soft delete) -->
                                <form action="{{ route('admin.users.softDelete', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-footer/>
    </div>
</x-app-layout>
