<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
        <p class="text-gray-600 mt-2">Email: {{ $user->email }}</p>

        @if(auth()->id() !== $user->id)
            <div class="mt-4">
                @if(auth()->user()->following->contains($user))
                    <form action="{{ route('users.unfollow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                            Unfollow
                        </button>
                    </form>
                @else
                    <form action="{{ route('users.follow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                            Follow
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
