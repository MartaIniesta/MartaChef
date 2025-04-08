<div class="p-4 bg-gray-100 border border-b-gray-200 rounded ml-{{ $level * 4 }}">
    <div class="flex justify-between items-center">
        <p class="font-semibold">{{ $comment->user->name }}</p>

        <div class="flex space-x-2">
            @can('update', $comment)
                <button wire:click="editComment({{ $comment->id }})">
                    <img src="{{ asset('storage/icons/editar.png') }}" class="h-6 w-6">
                </button>
            @endcan

            @can('delete', $comment)
                <button wire:click="deleteComment({{ $comment->id }})">
                    <img src="{{ asset('storage/icons/borrar.png') }}" class="h-6 w-6">
                </button>
            @endcan
        </div>
    </div>

    @if($editingCommentId === $comment->id)
        <div class="mt-4">
            <textarea
                wire:model="editingContent"
                maxlength="300"
                class="w-full border rounded-lg p-2"
                placeholder="{{ __('Edit your comment...') }}">
            </textarea>

            <div class="flex space-x-2 mt-2">
                <button wire:click="updateComment" class="bg-green-500 text-white p-2 rounded-lg">
                    {{ __('Update') }}
                </button>

                <button wire:click="cancelEdit" class="bg-gray-500 text-white p-2 rounded-lg">
                    {{ __('Cancel') }}
                </button>
            </div>

            <x-input-error :messages="$errors->get('editingContent')" class="mt-1" />
        </div>
    @else
        <p>{{ $comment->content }}</p>

        <div class="mt-2">
            @can('create', \App\Models\Comment::class)
                <button wire:click="replyToComment({{ $comment->id }})" class="bg-gray-200 hover:bg-[#B6D5E9] p-2 rounded-lg">
                    {{ __('Reply') }}
                </button>
            @endcan
        </div>

        @if($replyingToId === $comment->id)
            @include('livewire.comment-form', ['isReply' => true])
        @endif
    @endif

    @if($comment->replies->whereNull('deleted_at')->count() > 0)
        @include('livewire.reply-comments', ['comment' => $comment, 'level' => $level])
    @endif
</div>
