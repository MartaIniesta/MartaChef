<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto mb-4">
    @foreach($favorites as $favorite)
        <div class="relative border border-gray-300 p-4 text-center rounded-lg shadow-md bg-white">
            <div class="flex justify-start -mt-2">
                @if($isCreating && $favorite->id === $favoriteId)
                    <form wire:submit.prevent="createNote" class="mt-4 w-full flex items-center space-x-2">
                        <input type="text" wire:model="note" class="border rounded-lg w-64 p-2" placeholder="Escribe una nueva nota">

                        <div class="flex space-x-2">
                            <button type="submit" class="rounded-full">
                                <img src="{{ asset('storage/icons/verificacion.png') }}" alt="Agregar Nota" class="w-5 h-5">
                            </button>
                            <button type="button" wire:click="cancelEdit" class="rounded-full">
                                <img src="{{ asset('storage/icons/cancelar.png') }}" alt="Cancelar" class="w-4 h-4">
                            </button>
                        </div>
                    </form>

                @else
                    @if(!$favorite->note)
                        <div class="mt-4 flex justify-center space-x-2">
                            <button wire:click="startCreating({{ $favorite->id }})" class="rounded-full -mt-2">
                                <img src="{{ asset('storage/icons/agregar-nota.png') }}" alt="Añadir Nota" class="w-10 h-10">
                            </button>
                        </div>
                    @endif
                @endif
            </div>

            <a href="{{ route('posts.show', $favorite->post) }}">
                <img src="{{ asset('storage/' . $favorite->post->image) }}"
                     alt="{{ $favorite->post->title }}"
                     class="max-w-[80%] max-h-[200px] mx-auto rounded-md">
            </a>

            <a href="{{ route('posts.show', $favorite->post) }}" class="text-gray-800 hover:text-gray-600 font-semibold underline uppercase">
                {{ $favorite->post->title }}
            </a>

            <p class="mt-2 text-gray-700">
                {{ $favorite->post->description }}
            </p>

            <div class="flex justify-start mt-2">
                <small class="text-gray-500">
                    By {{ $favorite->post->user->name }} | {{ $favorite->post->created_at->format('d M Y') }}
                </small>
            </div>

            @if($favorite->note)
                <div class="mt-4 p-2 border-t border-gray-300 text-gray-600">
                    <strong>{{__('Note')}}:</strong> {{ $favorite->note }}
                </div>
            @endif

            @if($isEditing && $favorite->id === $favoriteId)
                <form wire:submit.prevent="updateNote" class="mt-4 w-full flex items-center space-x-2">
                    <input type="text" wire:model.defer="note" class="border rounded-lg w-64 p-2" placeholder="Editar nota">
                    <div class="flex space-x-2">
                        <button type="submit" class="rounded-full">
                            <img src="{{ asset('storage/icons/verificacion.png') }}" alt="Agregar Nota" class="w-5 h-5">
                        </button>
                        <button type="button" wire:click="cancelEdit" class="rounded-full">
                            <img src="{{ asset('storage/icons/cancelar.png') }}" alt="Cancelar" class="w-4 h-4">
                        </button>
                    </div>
                </form>
            @endif

            @if(!$isEditing && !$isCreating && $favorite->note)
                <div class="flex justify-center space-x-2">
                    <button wire:click="editNote({{ $favorite->id }})" class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] w-12 h-12 rounded-full">
                        <img src="{{ asset('storage/icons/editar-nota.png') }}" alt="Editar nota" class="w-10 h-10">
                    </button>
                    <button wire:click="deleteNote({{ $favorite->id }})" class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] w-12 h-12 rounded-full">
                        <img src="{{ asset('storage/icons/eliminar-nota.png') }}" alt="Eliminar nota" class="w-10 h-10">
                    </button>
                </div>
            @endif
        </div>
    @endforeach
</div>
