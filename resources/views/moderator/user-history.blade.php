<x-app-layout>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link/>
        </div>
    </div>

    <a href="{{ route('moderator.reports') }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
        < {{ __('Return') }}
    </a>

    <livewire:moderator.user-history :userId="$userId" />
</x-app-layout>
