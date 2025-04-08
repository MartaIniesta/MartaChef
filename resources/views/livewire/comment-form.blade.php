<div class="mt-4">
    <textarea
        wire:model="{{ $isReply ? 'replyContent' : 'content' }}"
        wire:key="textarea-{{ $resetKey ?? uniqid() }}"
        maxlength="300"
        class="w-full border rounded p-2"
        placeholder="{{ $isReply ? 'Escribe tu respuesta...' : 'Escribe un comentario...' }}">
    </textarea>

    <div class="flex space-x-2 mt-2">
        <button wire:click="{{ $isReply ? 'addReply' : 'addComment' }}" class="bg-green-500 text-white p-2 rounded-lg">
            {{ $isReply ? __('Reply') : __('Comment') }}
        </button>

        @if ($isReply)
            <button wire:click="cancelReply" class="bg-gray-500 text-white p-2 rounded-lg">
                {{ __('Cancel') }}
            </button>
        @endif
    </div>

    <x-input-error :messages="$errors->get($isReply ? 'replyContent' : 'content')" class="mt-1" />
</div>
