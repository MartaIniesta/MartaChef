<div>
    <h3 class="text-lg font-bold mb-4">Comentarios</h3>

    <!-- Muestra los comentarios -->
    <div class="space-y-4">
        @foreach($comments as $comment)
            @include('livewire.comment-item', ['comment' => $comment, 'level' => 0])
        @endforeach
    </div>

    <!-- Boton de CARGAR MAS -->
    @if($comments->count() < \App\Models\Comment::where('post_id', $postId)->whereNull('parent_id')->count())
        <button wire:click="loadMoreComments" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
            Cargar más comentarios
        </button>
    @endif

    <!-- Boton de CARGAR MENOS -->
    @if($commentsToShow > 4)
        <button wire:click="loadLessComments" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
            Cargar menos comentarios
        </button>
    @endif

    <!-- Boton de COMENTAR -->
    @auth
        @can('create', App\Models\Comment::class)
            <div class="mt-4">
                <textarea
                    wire:model="content"
                    wire:key="textarea-{{ $resetKey }}"
                    maxlength="300"
                    class="w-full border rounded p-2"
                    placeholder="Escribe un comentario...">
                </textarea>
                <button wire:click="addComment" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
                    Comentar
                </button>
            </div>

            <!-- Muestra un ERROR -->
            <div class="mt-3">
                @error('content')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        @endcan
    @endauth
</div>
