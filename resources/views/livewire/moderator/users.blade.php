<div>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link/>
        </div>
    </div>

    <div class="flex flex-1 min-h-screen bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <x-nav.moderate-browser/>

        <div class="flex-1 container mx-auto mb-2 ml-2 mr-2">
            <div class="w-44 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('USERS')}}
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-[#EDEDED]">
                    <th class="border p-2">{{__('ID')}}</th>
                    <th class="border p-2">{{__('Name')}}</th>
                    <th class="border p-2">{{__('Email')}}</th>
                    <th class="border p-2">{{__('Role')}}</th>
                    <th class="border p-2">{{__('State')}}</th>
                    <th class="border p-2">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="text-center">
                        <td class="border py-3">{{ $user->id }}</td>
                        <td class="border py-3">
                            <a href="{{ route('users.show', $user) }}" class="hover:underline">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="border py-3">{{ $user->email }}</td>
                        <td class="border py-3">
                            {{ ucfirst($user->getRoleNames()->first() ?? 'No Role') }}
                        </td>

                        <td class="border py-3">
                            @if ($user->trashed())
                                <span class="text-red-500 font-semibold">
                                    {{__('Deleted')}}
                                </span>
                            @else
                                <span class="text-green-500 font-semibold">
                                    {{__('Active')}}
                                </span>
                            @endif
                        </td>

                        <td class="border py-3 flex justify-center space-x-2">
                            @if ($user->trashed())
                                <button wire:click="restoreUser({{ $user->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    {{__('Restore')}}
                                </button>

                                <button wire:click="forceDeleteUser({{ $user->id }})" class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                    {{__('Perm. Delete')}}
                                </button>
                            @else
                                <button wire:click="softDeleteUser({{ $user->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    {{__('Delete')}}
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mb-2">
                {{ $users->links('vendor.pagination.pagination') }}
            </div>
        </div>
    </div>
</div>
