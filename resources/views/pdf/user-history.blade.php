<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            margin: 0;
            padding: 10px;
        }

        .user-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .user-info-img {
            display: table-cell;
            width: 100px;
            vertical-align: top;
        }

        .user-info-text {
            display: table-cell;
            padding-left: 20px;
            vertical-align: middle;
        }

        .user-info-img img {
            width: 100px;
            margin-left: -10px;
        }

        .user-info-text h1 {
            font-size: 20px;
            margin: 0;
            color: #393939;
            margin-left: -12px;
        }

        .user-info-text p {
            margin: 5px 0 0;
            font-weight: bold;
            color: #555;
            margin-left: -12px;
        }

        h2 {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 10px;
            color: #393939;
            padding-bottom: 5px;
        }

        p.italic {
            font-style: italic;
            color: #707070;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #EAEAEA;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #F8F8F8;
            color: #393939;
        }

        a {
            color: #1a0dab;
            text-decoration: none;
        }

        img {
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
        }

        .text-red { color: #e3342f; font-weight: bold; }
        .text-green { color: #38a169; font-weight: bold; }
    </style>
</head>
<body>
    <div class="user-info">
        <div class="user-info-img">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/default-images/default-profile.png' . $user->profile_image))) }}" alt="{{ $user->name }}">
        </div>
        <div class="user-info-text">
            <h1>Historial de {{ $user->name }}</h1>
            <p>Correo electrónico: {{ $user->email }}</p>
        </div>
    </div>

    <h2>Reportes Recibidos</h2>
    @if($reports->isEmpty())
        <p class="italic">Este usuario no ha sido reportado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Reportado por</th>
                    <th>Razón</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->reporter->name }}</td>
                        <td>{{ $report->reason }}</td>
                        <td>{{ ucfirst($report->status) }}</td>
                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Publicaciones</h2>
    @if($posts->isEmpty())
        <p class="italic">Este usuario no ha publicado recetas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            @if ($post->trashed())
                                <span class="text-red">Eliminado</span>
                            @else
                                <span class="text-green">Activo</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Comentarios</h2>
    @if($comments->isEmpty())
        <p class="italic">Este usuario no ha comentado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comentario</th>
                    <th>Publicación</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->post->id }}: {{ $comment->post->title }}</td>
                        <td>
                            @if ($comment->trashed())
                                <span class="text-red">Eliminado</span>
                            @else
                                <span class="text-green">Activo</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
