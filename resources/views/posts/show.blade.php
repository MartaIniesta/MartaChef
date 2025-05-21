<x-app-layout>
    <x-first-navigation-bar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-manage-link/>
            <x-nav.nav-moderate-link/>
            <x-nav.nav-blog-link/>
            <x-nav.nav-recipes-link/>
            <x-nav.nav-my-recipes-link/>
            <x-nav.nav-favorites-link/>
            <x-nav.nav-shared-recipes-link/>
        </div>
    </div>

    <a href="{{ url()->previous() }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
        < {{ __('Return') }}
    </a>

    <div class="mt-1 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="flex justify-between items-center">
                <a href="{{ route('users.show', $post->user) }}" class="text-gray-800 hover:text-gray-600 text-[17px]">
                    <p><strong>{{__('Author')}}:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
                </a>
                @auth
                    <a href="{{ route('posts.pdf', $post) }}" class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold text-[17px]">
                        <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] w-14 h-14 rounded-full">
                            <img src="{{ asset('storage/icons/pdf.png') }}" class="h-10 w-10">
                        </div>
                        {{__('Download PDF')}}
                    </a>
                @endauth
            </div>
            @auth
                @role('user', 'admin')
                    @livewire('favorite-button', ['postId' => $post->id])
                @endrole
            @endauth
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{ $post->title }}
                </h1>
            </div>

            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="mb-4 max-w-md mx-auto">
            <p class="mb-6">{{ $post->description }}</p>

            @auth
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2">
                        {{__('Ingredients')}}:
                    </h3>
                    <ul class="list-disc ml-6">
                        @foreach(array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                </div>
            @endauth

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">
                    {{__('Categories')}}:
                </h3>
                <ul class="list-disc ml-6">
                    @foreach ($post->categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">
                    {{__('Tags')}}:
                </h3>
                @if($post->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            @auth
                @can('update', $post)
                    <div class="mb-6">
                        <button onclick="window.location='{{ route('posts.edit', $post) }}'" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2">
                            {{__('Edit Recipe')}}
                        </button>
                    </div>
                @endcan

                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                            {{__('Delete')}}
                        </button>
                    </form>
                @endcan

                @can('rate', $post)
                    <h3 class="text-xl font-semibold mb-2">
                        {{__('Customer opinions')}}
                    </h3>
                    <livewire:post-rating :post="$post"/>
                @endcan

                <livewire:comments :postId="$post->id" />
                @else
                    <p class="text-gray-500 text-center mt-6">
                        <a href="{{ route('login') }}">
                            <strong>
                                {{__('Log in to see the full recipe.')}}
                            </strong>
                        </a>
                    </p>
            @endauth
        </div>
    </div>
</x-app-layout>
