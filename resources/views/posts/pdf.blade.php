<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 14px; }
        h1, h2 { color: #333; }
        .author { font-style: italic; color: #555; }
        .section { margin-bottom: 15px; }
        .ingredients li {
            margin: 3px 0;
            padding: 6px 0;
        }
        .img-container { text-align: center; margin: 15px 0; }
        .img-container img { max-width: 100%; height: auto; }
    </style>
</head>
<body>

<h1>{{ $post->title }}</h1>
<p class="author"><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>

@if($post->image)
    <div class="img-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $post->image))) }}" width="300" alt="{{ $post->title }}">
    </div>
@endif

<div class="section">
    <h2>Descripción</h2>
    <p>{{ $post->description }}</p>
</div>

@if($isAuthenticated)
    <div class="section">
        <h2>Ingredientes</h2>
        <ul class="ingredients">
            @foreach(array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                <li>{{ $ingredient }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
</html>
