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
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('COMMENTS')}}
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">ID</th>
                    <th class="border p-3">{{__('Comments')}}</th>
                    <th class="border p-3">{{__('Author')}}</th>
                    <th class="border p-3">{{__('Recipes')}}</th>
                    <th class="border p-3">{{__('State')}}</th>
                    <th class="border p-3">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                    <tr class="text-center">
                        <td class="border p-3">{{ $comment->id }}</td>

                        <td class="border p-3 max-w-xs truncate">
                            {{ $comment->content }}
                        </td>

                        <td class="border p-3">{{ $comment->user->name ?? 'Usuario desconocido' }}</td>

                        <td class="border p-3">
                            <a href="{{ route('posts.show', $comment->post_id) }}" class="text-blue-500 hover:underline">
                                {{ __('View recipe') }}
                            </a>
                        </td>

                        <td class="border p-3">
                            @if ($comment->trashed() || ($comment->parent && $comment->parent->trashed()))
                                <span class="text-red-500 font-semibold">
                                {{__('Deleted')}}
                            </span>
                            @else
                                <span class="text-green-500 font-semibold">
                                {{__('Asset')}}
                            </span>
                            @endif
                        </td>

                        <td class="border py-3 flex justify-center space-x-2">
                            @if ($comment->parent && $comment->parent->trashed())
                                <span class="text-gray-500 italic">{{ __('Action unavailable (parent deleted)') }}</span>
                            @else
                                @if ($comment->trashed())
                                    <button wire:click="restoreComment({{ $comment->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        {{__('Restore')}}
                                    </button>

                                    <button wire:click="forceDeleteComment({{ $comment->id }})" class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                        {{__('Perm. Delete')}}
                                    </button>
                                @else
                                    <button wire:click="softDeleteComment({{ $comment->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        {{__('Delete')}}
                                    </button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mb-2">
                {{ $comments->links('vendor.pagination.pagination') }}
            </div>
        </div>
    </div>
</div>
