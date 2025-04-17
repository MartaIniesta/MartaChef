<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            font-size: 14px;
            background-color: #F7F7F7;
            border: 4px dotted #B6D5E9;
            color: #333;
        }

        .fondo {
            max-width: 800px;
            margin: auto;
        }

        .titulo {
            text-align: center;
            color: #393939;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .author {
            color: #1F2937;
            margin-bottom: 15px;
            margin-top: -8px;
        }

        h2 {
            margin-bottom: 5px;
            color: #393939;
        }

        .section {
            margin-bottom: 25px;
        }

        .ingredients li {
            margin: 3px 0;
            padding: 6px 0;
        }

        .img-container {
            text-align: center;
            margin: 15px 0;
        }

        .img-container img {
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="fondo">
        <p class="author"><strong>Autor:</strong> {{ $post->user->name ?? 'Autor desconocido' }}</p>
        <h1 class="titulo">{{ $post->title }}</h1>

        @if($post->image)
            <div class="img-container">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $post->image))) }}" width="300" alt="{{ $post->title }}">
            </div>
        @endif

        <div class="section">
            <h2>Descripción</h2>
            <p>{{ $post->description }}</p>
        </div>

        <div class="section">
            <h2>Ingredientes</h2>
            <ul class="ingredients">
                @foreach(array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
