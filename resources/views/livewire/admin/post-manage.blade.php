<div>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link />
        </div>
    </div>

    <div class="flex flex-1 min-h-screen bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <x-nav.manage-browser />

        <div class="flex-1 container mx-auto mb-2 ml-2 mr-2">
            <div class="w-36 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{ __('RECIPES') }}
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-[#EDEDED]">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">{{ __('Title') }}</th>
                    <th class="border p-2">{{ __('Author') }}</th>
                    <th class="border p-2">{{ __('State') }}</th>
                    <th class="border p-2">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr class="text-center">
                        <td class="border py-3">{{ $post->id }}</td>

                        <td class="border py-3">
                            <a href="{{ route('posts.show', $post) }}" class="hover:underline">
                                {{ $post->title }}
                            </a>
                        </td>

                        <td class="border py-3">{{ $post->user->name ?? 'Autor desconocido' }}</td>

                        <td class="border py-3">
                            @if ($post->trashed())
                                <span class="text-red-500 font-semibold">{{ __('Deleted') }}</span>
                            @else
                                <span class="text-green-500 font-semibold">{{ __('Asset') }}</span>
                            @endif
                        </td>

                        <td class="border py-3 flex justify-center space-x-2">
                            @can('edit-posts', $post)
                                @if ($post->user && !$post->user->trashed())
                                    @if ($post->trashed())
                                        <button wire:click="restorePost({{ $post->id }})"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                            {{ __('Restore') }}
                                        </button>

                                        <button wire:click="forceDeletePost({{ $post->id }})" class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                            {{ __('Perm. Delete') }}
                                        </button>
                                    @else
                                        <button wire:click="softDeletePost({{ $post->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            {{ __('Delete') }}
                                        </button>

                                        <button onclick="window.location='{{ route('posts.edit', $post) }}'" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                                            {{ __('Edit') }}
                                        </button>
                                    @endif
                                @else
                                    <span class="text-gray-500 italic">
                                            {{ __('Action unavailable (user deleted)') }}
                                    </span>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mb-2">
                {{ $posts->links('vendor.pagination.pagination') }}
            </div>
        </div>
    </div>
</div>
