<div>
    <div class="flex items-center space-x-1 mb-4">
        @for ($i = 1; $i <= 5; $i++)
            <span class="text-3xl transition-colors duration-200
                        {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}">
                ★
            </span>
        @endfor
        <p class="ml-2 mt-1 text-xl">{{ number_format($averageRating, 1) }} de 5</p>
    </div>

    @auth
        @if(Auth::id() !== $post->user_id)
            <div class="flex items-center space-x-2 mb-4">
                <div class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <span
                            wire:click="rate({{ $i }})"
                            class="cursor-pointer text-3xl transition-colors duration-200
                                   {{ $i <= $userRating ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-300' }}">
                            @if($i <= $userRating)
                                ★
                            @else
                                ☆
                            @endif
                        </span>
                    @endfor
                </div>
            </div>
        @endif
    @endauth
</div>
