<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-recipes-link/>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-64 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('BLOG USERS')}}
            </h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 duration-300">
                    <div class="p-6 flex flex-col items-center text-center">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('default-images/default-profile.png') }}"
                             alt="{{ $user->name }}"
                             class="w-24 h-24 rounded-full shadow-md mb-4 object-cover">

                        <h2 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h2>

                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>

                        <div class="mt-4">
                            <a href="{{ route('users.show', $user) }}" class="inline-block bg-[#B6D5E9] px-4 py-2 rounded-lg hover:bg-[#5C99C1] transition duration-300 shadow-md">
                                {{__('View profile')}}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $users->links('vendor.pagination.pagination') }}
        </div>
    </div>
</x-app-layout>
