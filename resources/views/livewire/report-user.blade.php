<div>
    <button wire:click="openModal" class="text-red-500 font-semibold underline mt-4">
        {{__('Report')}}
    </button>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-semibold">
                    {{__('Report to')}} {{ $user->name }}
                </h2>

                <textarea wire:model="reason" class="w-full border rounded p-2 mt-2"
                          placeholder="Escribe la razón del reporte..."></textarea>

                <x-input-error :messages="$errors->get('reason')" class="mt-1" />

                <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-3 py-1 rounded">
                        {{__('Cancel')}}
                    </button>

                    <button wire:click="submitReport" class="bg-red-600 text-white px-3 py-1 rounded">
                        {{__('Send')}}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
