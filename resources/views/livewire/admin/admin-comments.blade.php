<div>
    <x-first-navigation-bar/>

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-blog-link/>
            </div>
        </div>
    </div>

    <div class="flex flex-1 min-h-screen bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <x-nav.manage-browser/>

        <div class="flex-1 container mx-auto mb-2 ml-2 mr-2">
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('COMMENTS')}}
                </h1>
            </div>

            <div class="text-right mb-4">
                <button wire:click="deleteOldComments"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    {{__('Delete old comments')}}
                </button>

                @if ($deleteMessage)
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                         class="mt-2 text-sm text-gray-700 transition-opacity duration-500">
                        {{ $deleteMessage }}
                    </div>
                @endif
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
                    <tr wire:key="comment-{{ $comment->id }}" class="text-center">
                        <td class="border p-3">{{ $comment->id }}</td>

                        <td class="border p-3 max-w-xs">
                            @if ($editingCommentId === $comment->id)
                                <textarea wire:model.defer="editingContent"
                                          class="w-full p-2 border rounded resize-none"
                                          rows="2"></textarea>

                                <div class="mt-2 flex justify-center space-x-2">
                                    <button wire:click="updateComment"
                                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                        {{ __('Save') }}
                                    </button>
                                    <button wire:click="cancelEdit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-gray-500">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            @else
                                <div class="whitespace-pre-wrap break-words">{{ $comment->content }}</div>
                            @endif
                        </td>

                        <td class="border p-3">{{ $comment->user?->name ?? __('User deleted') }}</td>

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
                            @if ($comment->user && $comment->user->trashed())
                                <span class="text-gray-500 italic">{{ __('Action unavailable (user deleted)') }}</span>
                            @elseif ($comment->parent && $comment->parent->trashed())
                                <span class="text-gray-500 italic">{{ __('Action unavailable (parent deleted)') }}</span>
                            @else
                                @if ($comment->trashed())
                                    <button wire:click="restoreComment({{ $comment->id }})"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        {{__('Restore')}}
                                    </button>

                                    <button wire:click="forceDeleteComment({{ $comment->id }})"
                                            class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                        {{__('Perm. Delete')}}
                                    </button>
                                @else
                                    <button wire:click="editComment({{ $comment->id }})"
                                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        {{ __('Edit') }}
                                    </button>

                                    <button wire:click="softDeleteComment({{ $comment->id }})"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
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
                {{ $comments->links('vendor.pagination.pagination-livewire') }}
            </div>
        </div>
    </div>
</div>
