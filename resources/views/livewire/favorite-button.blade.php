<button wire:click="toggleFavorite" class="items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] w-8 h-8 rounded-full">
    @if ($isFavorite)
        ❤️
    @else
        🤍
    @endif
</button>
