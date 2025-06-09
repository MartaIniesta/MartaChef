<x-app-layout>
    <x-first-navigation-bar />

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-manage-link />
                <x-nav.nav-moderate-link />
                <x-nav.nav-blog-link/>
                <x-nav.nav-users-link />
                <x-nav.nav-recipes-link />
            </div>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-64 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('NOTIFICATIONS')}}
            </h1>
        </div>

        <div class="max-w-4xl mx-auto mt-8 px-7">
            @if ($notifications->count() > 0)
                <ul class="space-y-4">
                    @foreach ($notifications as $notification)
                        <li class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 flex justify-between items-center
                            {{ is_null($notification->read_at) ? 'bg-blue-50' : 'bg-white' }}">

                            <div class="flex-1 mr-4">
                                <p class="text-gray-800 font-medium">
                                    {{ $notification->data['message'] ?? 'Notificación' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Marcar como leído">
                                    <img src="{{ asset('storage/icons/verificacion.png') }}" alt="Marcar como leído" class="w-6 h-6 hover:scale-110 transition-transform">
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center text-gray-500 text-sm">
                    {{__('You don\'t have notifications.')}}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
