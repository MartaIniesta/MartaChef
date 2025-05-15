@if ($paginator->hasPages())
    <div class="mt-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center space-x-2">
            <!-- Página anterior -->
            <div class="flex-shrink-0">
                @if ($paginator->onFirstPage())
                    <span class="px-4 py-2 text-[16px] text-gray-400 border border-gray-300 rounded cursor-not-allowed">‹</span>
                @else
                    <button wire:click="previousPage" class="px-4 py-2 text-[16px] bg-[#F0F0F0] border border-[#DFDFDF] rounded hover:bg-[#B6D5E9] hover:border-[#9AC4DF] shadow-lg">‹</button>
                @endif
            </div>

            <!-- Números de página -->
            <div class="flex-1 flex justify-center space-x-2">
                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-2 text-[16px] bg-[#B6D5E9] border border-[#9AC4DF] rounded">{{ $page }}</span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="px-4 py-2 text-[16px] bg-[#F0F0F0] border border-[#DFDFDF] rounded hover:bg-[#B6D5E9] hover:border-[#9AC4DF] shadow-lg">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <!-- Página siguiente -->
            <div class="flex-shrink-0">
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" class="px-4 py-2 text-[16px] bg-[#F0F0F0] border border-[#DFDFDF] rounded hover:bg-[#B6D5E9] hover:border-[#9AC4DF] shadow-lg">›</button>
                @else
                    <span class="px-4 py-2 text-[16px] text-gray-500 border border-gray-300 rounded cursor-not-allowed">›</span>
                @endif
            </div>
        </div>
    </div>
@endif
