<div class="p-4 bg-gray-100 rounded ml-{{ $level * 4 }}">
    <p class="font-semibold">{{ $comment->user->name }}</p>

    @if($editingCommentId === $comment->id)
        <!-- ACTUALIZAR -->
        <textarea wire:model="editingContent" class="w-full border rounded p-2"></textarea>
        <button wire:click="updateComment" class="bg-green-500 text-white px-4 py-1 rounded mt-2">Actualizar</button>
    @else
        <p>{{ $comment->content }}</p>

        <!-- Botón EDITAR -->
        @if(auth()->user()->can('update', $comment))
            <button wire:click="editComment({{ $comment->id }})" class="text-yellow-500">Editar</button>
        @endif

        <!-- Botón ELIMINAR -->
        @if(auth()->user()->can('delete', $comment))
            <button wire:click="deleteComment({{ $comment->id }})" class="text-red-500 ml-2">Eliminar</button>
        @endif
    @endif

    <!-- Botón RESPONDER -->
    @if($editingCommentId !== $comment->id)
        @can('create', App\Models\Comment::class)
            <button wire:click="replyToComment({{ $comment->id }})" class="text-blue-500 ml-2">Responder</button>

            <!-- Formulario para RESPONDER -->
            @if($replyingToId === $comment->id)
                <div class="mt-2 ml-4">
                    <textarea wire:model="replyContent" class="w-full border rounded p-2" placeholder="Escribe tu respuesta..."></textarea>
                    <button wire:click="addReply" class="bg-purple-500 text-white px-4 py-2 rounded mt-2">Responder</button>
                    <button wire:click="cancelReply" class="bg-gray-500 text-white px-4 py-2 rounded mt-2 ml-2">Cancelar</button>
                </div>
            @endif
        @endcan
    @endif

    <!-- Muestra los comentarios recursivos -->
    @if($comment->replies->count() > 0)
        <div class="mt-4 ml-6 border-l-2 pl-4">
            @foreach($comment->replies->take($this->repliesToShow[$comment->id] ?? 1) as $reply)
                @include('livewire.comment-item', ['comment' => $reply, 'level' => $level + 1])
            @endforeach
        </div>

        <!-- Boton de CARGAR MAS -->
        @if($comment->replies->count() > ($this->repliesToShow[$comment->id] ?? 1))
            <button wire:click="loadMoreReplies({{ $comment->id }})" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                Cargar más respuestas
            </button>
        @endif

        <!-- Boton de CARGAR MENOS -->
        @if(isset($this->repliesToShow[$comment->id]) && $this->repliesToShow[$comment->id] > 1)
            <button wire:click="loadLessReplies({{ $comment->id }})" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
                Cargar menos respuestas
            </button>
        @endif
    @endif
</div>
