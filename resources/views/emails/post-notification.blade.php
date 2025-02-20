<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva receta de {{ $author->name }}</title>
</head>
<body>
    <h1>{{ $author->name }} ha publicado una nueva receta</h1>
    <p>Título: {{ $post->title }}</p>
    <p>Descripcion: {{ $post->description }}</p>

    <p>¡No te lo pierdas!</p>
</body>
</html>
