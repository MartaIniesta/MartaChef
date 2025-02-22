<div class="p-4 bg-gray-100 rounded ml-{{ $level * 4 }}">
    <p class="font-semibold">{{ $comment->user->name }}</p>

    @if($editingCommentId === $comment->id)
        <textarea wire:model="editingContent" maxlength="300" class="w-full border rounded p-2"></textarea>
        <button wire:click="updateComment" class="bg-green-500 text-white px-4 py-1 rounded mt-2">
            {{__('Update')}}
        </button>

        <div class="mt-3">
            @error('editingContent')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
    @else
        <p>{{ $comment->content }}</p>

        @if(auth()->user()->can('update', $comment))
            <button wire:click="editComment({{ $comment->id }})" class="text-yellow-500">
                {{__('Edit')}}
            </button>
        @endif

        @if(auth()->user()->can('delete', $comment))
            <button wire:click="deleteComment({{ $comment->id }})" class="text-red-500 ml-2">
                {{__('Delete')}}
            </button>
        @endif
    @endif

    @if($editingCommentId !== $comment->id)
        @can('create', App\Models\Comment::class)
            <button wire:click="replyToComment({{ $comment->id }})" class="text-blue-500 ml-2">
                {{__('Reply')}}
            </button>

            @if($replyingToId === $comment->id)
                <div class="mt-2 ml-4">
                    <textarea
                        wire:model="replyContent"
                        maxlength="300"
                        class="w-full border rounded p-2"
                        placeholder="Escribe tu respuesta..."></textarea>
                    <button wire:click="addReply" class="bg-purple-500 text-white px-4 py-2 rounded mt-2">
                        {{__('Reply')}}
                    </button>
                    <button wire:click="cancelReply" class="bg-gray-500 text-white px-4 py-2 rounded mt-2 ml-2">
                        {{__('Cancel')}}
                    </button>

                    <div class="mt-3">
                        @error('replyContent')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        @endcan
    @endif

    @if($comment->replies->count() > 0)
        @include('livewire.reply-comments', ['comment' => $comment, 'level' => $level])
    @endif
</div>
