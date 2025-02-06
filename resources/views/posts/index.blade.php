<x-app-layout>
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo / Home -->
            <a href="{{ route('home') }}" class="text-white text-xl font-bold">
                Home
            </a>

            <!-- Menú de navegación -->
            <div class="space-x-4">
                @auth
                    <a href="{{ route('posts.myPosts') }}" class="text-gray-300 hover:text-white">
                        Mis Recetas
                    </a>
                    <a href="{{ route('posts.shared') }}" class="text-gray-300 hover:text-white">
                        Recetas Compartidas
                    </a>
                    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600">
                        Crear Receta
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <h1>Blog</h1>
    @foreach ($publicPosts as $post)
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
            <h2>
                <a style="text-decoration: none; color: inherit;" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 250px;">
            <p>{{ $post->description }}</p>
            <small>By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}</small>
        </div>
    @endforeach
</x-app-layout>
