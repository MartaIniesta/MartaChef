<div>
    <x-first-navigation-bar />

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-manage-link/>
                <x-nav.nav-blog-link/>
                <x-nav.nav-recipes-link/>
                <x-nav.nav-my-recipes-link/>
                <x-nav.nav-shared-recipes-link/>
            </div>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-48 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{ __('MY FAVORITE RECIPES') }}
            </h1>
        </div>

        @if($favorites->isEmpty())
            <p class="text-center text-gray-500">
                {{ __('You don\'t have any recipes saved in your favorites yet.') }}
            </p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl mx-auto mb-4">
                @foreach($favorites as $favorite)
                    <div class="relative border border-gray-300 p-4 text-center rounded-lg shadow-md bg-white">
                        <div class="flex justify-start -mt-2">
                            @if($creatingNoteForPostId === $favorite->id)
                                <form wire:submit.prevent="createNote" class="mt-4 w-full">
                                    <div class="flex items-center space-x-2">
                                        <input type="text" wire:model="note" class="border rounded-lg w-64 p-2" placeholder="Escribe una nueva nota">
                                        <div class="flex space-x-2">
                                            <button type="submit" class="rounded-full">
                                                <img src="{{ asset('storage/icons/verificacion.png') }}" alt="Agregar Nota" class="w-5 h-5">
                                            </button>
                                            <button type="button" wire:click="cancelEdit" class="rounded-full">
                                                <img src="{{ asset('storage/icons/cancelar.png') }}" alt="Cancelar" class="w-4 h-4">
                                            </button>
                                        </div>
                                    </div>

                                    @error('note')
                                    <div class="mt-1 text-left">
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </form>
                            @elseif(empty($favorite->pivot?->note) && $creatingNoteForPostId !== $favorite->id && $editingNoteForPostId !== $favorite->id)
                                <div class="mt-4 flex justify-center space-x-2">
                                    <button wire:click="startCreating({{ $favorite->id }})" class="rounded-full -mt-2">
                                        <img src="{{ asset('storage/icons/agregar-nota.png') }}" alt="Añadir Nota" class="w-10 h-10">
                                    </button>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('posts.show', $favorite) }}">
                            <img src="{{ asset('storage/' . $favorite->image) }}"
                                 alt="{{ $favorite->title }}"
                                 class="max-w-[80%] max-h-[200px] mx-auto rounded-md">
                        </a>

                        <a href="{{ route('posts.show', $favorite) }}" class="text-gray-800 hover:text-gray-600 font-semibold underline uppercase">
                            {{ $favorite->title }}
                        </a>

                        <p class="mt-2 text-gray-700">
                            {{ $favorite->description }}
                        </p>

                        <div class="flex justify-center mt-2">
                            <small class="text-gray-500">
                                By {{ $favorite->user->name }} | <x-date :date="$favorite->created_at" />
                            </small>
                        </div>

                        @if(!empty($favorite->pivot?->note))
                            <div class="mt-4 p-2 border-t border-gray-300 text-gray-600 break-words max-w-full">
                                <strong>{{ __('Note') }}:</strong>
                                <p class="whitespace-pre-wrap break-words">{{ $favorite->pivot->note }}</p>
                            </div>
                        @endif

                        @if($editingNoteForPostId === $favorite->id)
                            <form wire:submit.prevent="updateNote" class="mt-4 w-full">
                                <div class="flex items-center space-x-2">
                                    <input type="text" wire:model.defer="note" class="border rounded-lg w-64 p-2" placeholder="Editar nota">
                                    <div class="flex space-x-2">
                                        <button type="submit" class="rounded-full">
                                            <img src="{{ asset('storage/icons/verificacion.png') }}" alt="Guardar Nota" class="w-5 h-5">
                                        </button>
                                        <button type="button" wire:click="cancelEdit" class="rounded-full">
                                            <img src="{{ asset('storage/icons/cancelar.png') }}" alt="Cancelar" class="w-4 h-4">
                                        </button>
                                    </div>
                                </div>

                                @error('note')
                                <div class="mt-1 text-left">
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                </div>
                                @enderror
                            </form>
                        @elseif(!empty($favorite->pivot?->note) && $editingNoteForPostId !== $favorite->id && $creatingNoteForPostId !== $favorite->id)
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
        @endif
    </div>
</div>
