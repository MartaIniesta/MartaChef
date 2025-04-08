<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-moderate-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-users-link/>
            <x-nav.nav-recipes-link/>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="w-48 mx-auto pt-6">
            <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                {{__('MY FAVORITE RECIPES')}}
            </h1>
        </div>
        <div class="container">
            @livewire('favorite-list')
        </div>
    </div>
</x-app-layout>
