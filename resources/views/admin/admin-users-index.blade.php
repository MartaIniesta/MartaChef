<x-app-layout>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link/>
            <x-nav.nav-manage-link/>

            <a href="{{ route('admin.posts') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                    <img src="{{ asset('storage/icons/administrar2.png') }}" class="h-12 w-12">
                </div>
                {{__('MANAGE RECIPES')}}
            </a>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="container mx-auto mt-8">
            <div class="w-1/4 mx-auto pb-3">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('MANAGE USERS')}}
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">{{__('Name')}}</th>
                    <th class="border p-3">{{__('Email')}}</th>
                    <th class="border p-3">{{__('State')}}</th>
                    <th class="border p-3">{{__('Role')}}</th>
                    <th class="border p-3">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="text-center">
                        <td class="border p-3">{{ $user->name }}</td>
                        <td class="border p-3">{{ $user->email }}</td>
                        <td class="border p-3">
                            @if ($user->trashed())
                                <span class="text-red-500 font-semibold">
                                    {{__('Deleted')}}
                                </span>
                            @else
                                <span class="text-green-500 font-semibold">
                                    {{__('Asset')}}
                                </span>
                            @endif
                        </td>

                        <td class="border p-3">
                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <select name="role" class="border rounded p-1">
                                    @foreach(['user', 'admin', 'moderator'] as $role)
                                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mt-1">
                                    {{__('Assign')}}
                                </button>
                            </form>
                        </td>

                        <td class="border p-3 flex flex-col items-center space-y-2">
                            @if ($user->trashed())
                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        {{__('Restore')}}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.forceDelete', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar permanentemente este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                        {{__('Permanently Delete')}}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.softDelete', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        {{__('Delete')}}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
