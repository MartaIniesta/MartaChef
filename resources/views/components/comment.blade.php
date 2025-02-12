<x-app-layout>
    <li class="ml-{{ $comment->parent_id ? '10' : '0' }} border-l-2 border-gray-300 pl-2">
        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

        @if(auth()->user()->id === $comment->user_id || auth()->user()->hasRole('moderator'))
            <!-- Botón de EDITAR -->
            @can('edit-comments')
                <button onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')" class="text-blue-500 hover:text-blue-700">
                    Editar
                </button>

                <form id="edit-comment-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" class="hidden mt-2">
                    @csrf
                    @method('PATCH')
                    <textarea name="content" required class="w-full p-2 border border-gray-300 rounded">{{ $comment->content }}</textarea>
                    <div class="mt-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                        <button type="button" onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Cancelar
                        </button>
                    </div>
                </form>
            @endcan

            <!-- Botón de ELIMINAR -->
            @can('delete-comments')
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este comentario?')" class="text-red-500 hover:text-red-700">
                        Eliminar
                    </button>
                </form>
            @endcan
        @endif

        <!-- Formulario para RESPONDER -->
        @can('reply-comments')
            <form action="{{ route('comments.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" required placeholder="Responder a este comentario..." class="w-full p-2 border border-gray-300 rounded"></textarea>
                <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                    Responder
                </button>
            </form>
        @endcan

        <!-- RESPUESTAS -->
        @if ($comment->replies->count())
            <ul class="pl-4">
                @foreach ($comment->replies as $reply)
                    <x-comment :comment="$reply" />
                @endforeach
            </ul>
        @endif
    </li>
</x-app-layout>
