<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de nuevo post</title>
</head>

<body>
    <h1>¡Nuevo post publicado por {{ $post->user->name }}!</h1>
    <p>Hola,</p>
    <p>El usuario {{ $post->user->name }} ha publicado una nueva receta: <strong>{{ $post->title }}</strong>.</p>
    <p>Visítalo ahora y disfruta de esta nueva receta.</p>
</body>

</html>
