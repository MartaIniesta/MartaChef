<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Eliminado</title>
</head>
<body>
    <h1>Hola, {{ $post->user->name }}</h1>
    <p>Lamentamos informarte que tu post titulado <strong>"{{ $post->title }}"</strong> ha sido eliminado por altos rangos.</p>
    <p>Si tienes dudas, puedes ponerte en contacto con nosotros.</p>
    <p>Saludos, <br> El equipo de MartaChef</p>
</body>
</html>
