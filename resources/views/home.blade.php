<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <h1>Bienvenido a mi blog</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-primary">Ver Recetas</a>
</div>
</body>
</html>
