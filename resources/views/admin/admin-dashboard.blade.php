<x-app-layout>
    <x-first-navigation-bar />

    <nav>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center py-8 space-x-8">
                <a href="{{ route('posts.index') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-16 h-16 rounded-lg mb-1">
                        <img src="{{ asset('storage/icons/blog.png') }}" class="h-12 w-12">
                    </div>
                    {{ __('BLOG') }}
                </a>
            </div>
        </div>
    </nav>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="w-1/3 mx-auto pt-4 -mt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('WELCOME TO THE ADMINISTRATION PANEL')}}
                </h1>
            </div>

            <div class="flex justify-center space-x-4 mt-14 pb-14">
                <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-1/3 h-16 rounded-lg mb-1">
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        {{__('MANAGE USERS')}}
                    </a>
                </div>
                <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] border-2 border-dotted border-gray-500 w-1/3 h-16 rounded-lg mb-1">
                    <a href="{{ route('admin.posts') }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold">
                        {{__('MANAGE RECIPES')}}
                    </a>
                </div>
            </div>
        </div>

        <x-footer/>
    </div>
</x-app-layout>
