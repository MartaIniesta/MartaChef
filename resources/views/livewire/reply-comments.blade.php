<div class="mt-4 ml-6 border-l-2 pl-4">
    @foreach($comment->replies->take($this->repliesToShow[$comment->id] ?? 1) as $reply)
        @include('livewire.comment-item', ['comment' => $reply, 'level' => $level + 1])
    @endforeach

    <!-- Botón para CARGAR MÁS respuestas -->
    @if($comment->replies->count() > ($this->repliesToShow[$comment->id] ?? 1))
        <button wire:click="loadMoreReplies({{ $comment->id }})" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
            Cargar más respuestas
        </button>
    @endif

    <!-- Botón para CARGAR MENOS respuestas -->
    @if(isset($this->repliesToShow[$comment->id]) && $this->repliesToShow[$comment->id] > 1)
        <button wire:click="loadLessReplies({{ $comment->id }})" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
            Cargar menos respuestas
        </button>
    @endif
</div>
