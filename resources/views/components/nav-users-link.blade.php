@if(auth()->check() && (auth()->user()->hasRole('user') || auth()->user()->hasRole('admin')) || !auth()->check())
    <a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
            <img src="{{ asset('storage/icons/users.png') }}" class="h-12 w-12">
        </div>
        {{__('USERS')}}
    </a>
@endif
