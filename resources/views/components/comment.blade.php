<li style="margin-left: {{ $comment->parent_id ? '40px' : '0px' }}; border-left: 2px solid #ccc; padding-left: 10px;">
    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

    @auth
        @if(auth()->id() === $comment->user_id)
            <!-- Botón para editar -->
            <button onclick="document.getElementById('edit-comment-{{ $comment->id }}').style.display='block'">
                Editar
            </button>

            <!-- Formulario de edición oculto -->
            <form id="edit-comment-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" style="display: none;">
                @csrf
                @method('PATCH')
                <textarea name="content" required>{{ $comment->content }}</textarea>
                <button type="submit">Guardar</button>
                <button type="button" onclick="document.getElementById('edit-comment-{{ $comment->id }}').style.display='none'">Cancelar</button>
            </form>

            <!-- Botón para eliminar -->
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este comentario?')">Eliminar</button>
            </form>
        @endif
    @endauth

    <!-- Formulario para responder a este comentario -->
    <form action="{{ route('comments.store') }}" method="POST" style="margin-top: 5px;">
        @csrf
        <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="content" required placeholder="Responder a este comentario..." style="width: 100%;"></textarea>
        <button type="submit">Responder</button>
    </form>

    <!-- Renderizar respuestas recursivamente -->
    @if ($comment->replies->count())
        <ul>
            @foreach ($comment->replies as $reply)
                <x-comment :comment="$reply" />
            @endforeach
        </ul>
    @endif
</li>
