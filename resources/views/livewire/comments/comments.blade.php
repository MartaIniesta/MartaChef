<div>
    <h3 class="text-lg font-bold mb-4">{{ __('Comments') }}</h3>

    <div class="space-y-4">
        @foreach($comments as $comment)
            @include('livewire.comments.comment-item', ['comment' => $comment, 'level' => 0])
        @endforeach
    </div>

    <div class="mt-4">
        @if($comments->count() < \App\Models\Comment::where('post_id', $postId)->whereNull('parent_id')->whereDoesntHave('parent', fn($q) => $q->onlyTrashed())->count())
            <button wire:click="loadMoreComments" class="bg-blue-200 p-2 rounded-lg">
                {{ __('Load more comments') }}
            </button>
        @endif

        @if($commentsToShow > 4)
            <button wire:click="loadLessComments" class="bg-blue-200 p-2 rounded-lg">
                {{ __('Load fewer comments') }}
            </button>
        @endif
    </div>

    @auth
        @include('livewire.comments.comment-form', ['isReply' => false])
    @endauth
</div>
