<aside class="w-60 bg-[#EDEDED]">
    <h2 class="text-[18px] text-gray-800 font-semibold p-3">
        {{ __('MODERATION PANEL') }}
    </h2>

    <nav class="space-y-1">
        <div class="hover:bg-[#B6D5E9] transition-all duration-300">
            <a href="{{ route('moderator.posts') }}" class="flex text-[17px] text-gray-800 hover:text-gray-600 font-semibold py-2 px-4">
                <img src="{{ asset('storage/icons/recipes.png') }}" class="h-6 w-6 mr-1">
                {{ __('Recipes') }}
            </a>
        </div>

        <div class="hover:bg-[#B6D5E9] transition-all duration-300">
            <a href="{{ route('moderator.users') }}" class="flex text-[17px] text-gray-800 hover:text-gray-600 font-semibold py-2 px-4">
                <img src="{{ asset('storage/icons/users.png') }}" class="h-6 w-6 mr-1">
                {{ __('Users') }}
            </a>
        </div>

        <div class="hover:bg-[#B6D5E9] transition-all duration-300">
            <a href="{{ route('moderator.comments') }}" class="flex text-[17px] text-gray-800 hover:text-gray-600 font-semibold py-2 px-4">
                <img src="{{ asset('storage/icons/comentarios.png') }}" class="h-6 w-6 mr-1">
                {{ __('Comments') }}
            </a>
        </div>

        <div class="hover:bg-[#B6D5E9] transition-all duration-300">
            <a href="{{ route('moderator.reports') }}" class="flex text-[17px] text-gray-800 hover:text-gray-600 font-semibold py-2 px-4">
                <img src="{{ asset('storage/icons/reporte.png') }}" class="h-6 w-6 mr-1">
                {{ __('Reports') }}
            </a>
        </div>
    </nav>
</aside>
