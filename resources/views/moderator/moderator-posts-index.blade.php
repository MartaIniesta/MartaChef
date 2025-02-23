<x-app-layout>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav-moderate-link/>
            <x-nav-blog-link/>
        </div>
    </div>

    <div class="bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="container mx-auto mt-8">
            <div class="w-1/4 mx-auto pb-3">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('MODERATE RECIPES')}}
                </h1>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">ID</th>
                    <th class="border p-3">{{__('Title')}}</th>
                    <th class="border p-3">{{__('Author')}}</th>
                    <th class="border p-3">{{__('State')}}</th>
                    <th class="border p-3">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr class="text-center">
                        <td class="border p-3">{{ $post->id }}</td>

                        <td class="border p-3">{{ $post->title }}</td>

                        <td class="border p-3">{{ $post->user->name ?? 'Autor desconocido' }}</td>

                        <td class="border p-3">
                            @if ($post->trashed())
                                <span class="text-red-500 font-semibold">
                                    {{__('Deleted')}}
                                </span>
                            @else
                                <span class="text-green-500 font-semibold">
                                    {{__('Asset')}}
                                </span>
                            @endif
                        </td>

                        <td class="border p-3 flex justify-center space-x-2">
                            @if ($post->trashed())
                                <form action="{{ route('moderator.posts.restore', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        {{__('Restore')}}
                                    </button>
                                </form>

                                <form action="{{ route('moderator.posts.forceDelete', $post->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar permanentemente este post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                        {{__('Permanently Delete')}}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('moderator.posts.softDelete', $post->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        {{__('Delete')}}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-footer/>
    </div>
</x-app-layout>
