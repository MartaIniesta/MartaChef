<x-app-layout>
    <x-first-navigation-bar />

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <x-nav.nav-manage-link />
                <x-nav.nav-moderate-link />
                <x-nav.nav-blog-link />
            </div>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-36 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mt-5 border-y-2 border-[#343434] py-3">
                {{ __('PROFILE') }}
            </h1>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="flex items-center my-8">
                <div class="flex-grow border-t border-gray-300"></div>
                <h2 class="mx-7 px-7 py-3 border border-gray-400 font-semibold uppercase tracking-wide">
                    {{ __('INFORMATION') }}
                </h2>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="border border-gray-300 p-6 rounded-lg shadow-md bg-white">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="flex items-center my-8">
                <div class="flex-grow border-t border-gray-300"></div>
                <h2 class="mx-7 px-7 py-3 border border-gray-400 font-semibold uppercase tracking-wide">
                    {{ __('CONFIGURATION') }}
                </h2>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <div class="border border-gray-300 p-6 rounded-lg shadow-md bg-white max-w-2xl mx-auto mb-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
