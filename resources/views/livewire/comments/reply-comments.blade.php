<div class="mt-4 ml-6 border-l-2 pl-4">
    @foreach($comment->replies->whereNull('deleted_at')->take($this->repliesToShow[$comment->id] ?? 1) as $reply)
        @include('livewire.comments.comment-item', ['comment' => $reply, 'level' => $level + 1])
    @endforeach

    <div class="mt-2">
        @if($comment->replies->count() > ($this->repliesToShow[$comment->id] ?? 1))
            <button wire:click="loadMoreReplies({{ $comment->id }})">
                {{ __('Load more comments') }}
            </button>
        @endif

        @if(isset($this->repliesToShow[$comment->id]) && $this->repliesToShow[$comment->id] > 1)
            <button wire:click="loadLessReplies({{ $comment->id }})">
                {{ __('Load fewer comments') }}
            </button>
        @endif
    </div>
</div>
