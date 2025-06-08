<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de {{ $user->name }}</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #f8f8f8;
            height: 50px;
            width: 100%;
        }

        .logo {
            position: absolute;
            margin-left: 80px;
            width: 90px;
            height: 170px;
            background-color: #b6d5e9;
            display: flex;
            justify-content: center;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .img-logo {
            width: 92px;
            height: 112px;
            padding-top: 55px;
        }

        .img-user {
            width: 50px;
            height: auto;
            float: right;
            margin-right: 80px;
            margin-top: -1px;
        }

        .user-info {
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }

        .user-info h1 {
            color: #393939;
            margin-top: 35px;
            border-top: #b6d5e9 dotted 2px;
            border-bottom: #b6d5e9 dotted 2px;
        }

        .user-info p {
            margin-top: -15px;
            font-size: 15px;
        }

        h2 {
            font-size: 18px;
            margin: 50px 20px 10px 20px;
            color: #393939;
            border-bottom: #b6d5e9 solid 1px;
        }

        p.italic {
            font-style: italic;
            color: #707070;
            margin: 20px;
        }

        .reporting-table {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .post-table {
            width: 100%;
            margin-top: -8px;
            border-collapse: separate;
            border-spacing: 20px 20px;
        }

        .post-table td {
            border: 1px solid #EAEAEA;
            padding: 8px;
            vertical-align: top;
            background-color: #FBFBFB;
            border-radius: 8px;
            width: 33.33%;
        }

        .post-card.empty {
            border: none;
            background-color: transparent;
        }

        .post-img {
            width: 150px;
            height: 150px;
        }

        .post-date {
            font-size: 13px;
            color: #555;
        }

        .post-title {
            font-size: 15px;
        }

        .comment {
            margin-top: -20px;
        }

        .comments-table{
            margin: 20px;
        }

        strong {
            color: #393939;
        }

        .text-red {
            color: #ef4444;
        }

        .text-green {
            color: #22c55e;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img class="img-logo"
                 src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/logo/logo-MartaChef.png' . $user->profile_image))) }}"
                 alt="MartaChef">
        </div>

        <img class="img-user"
             src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/default-images/default-profile.png' . $user->profile_image))) }}"
             alt="{{ $user->name }}">
    </div>

    <div class="user-info">
        <h1>Historial de {{ $user->name }}</h1>
        <p>Correo electrónico: {{ $user->email }}</p>
    </div>

    <h2>> Reportes Recibidos</h2>
    @if($reports->isEmpty())
        <p class="italic">Este usuario no ha sido reportado.</p>
    @else
        <div class="reporting-table">
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
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->pivot->reason }}</td>
                        <td>{{ ucfirst($report->pivot->status) }}</td>
                        <td>{{ $report->pivot->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h2>> Publicaciones</h2>
    @if($posts->isEmpty())
        <p class="italic">Este usuario no ha publicado recetas.</p>
    @else
        <table class="post-table">
            <tbody>
            @foreach ($posts->chunk(3) as $chunk)
                <tr>
                    @foreach ($chunk as $post)
                        <td>
                            @if($post->image)
                                <img class="post-img"
                                     src= "data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $post->image))) }}"
                                     alt="{{ $post->title }}">
                            @endif
                            <p class="post-title">{{ $post->title }}</p>
                            <p>
                                <strong>ID:</strong> {{ $post->id }} |
                                <strong>Estado:</strong>
                                @if ($post->trashed())
                                    <span class="text-red">Eliminado</span>
                                @else
                                    <span class="text-green">Activo</span>
                                @endif
                            </p>
                            <p class="post-date">{{ $post->created_at->format('d/m/Y') }}</p>
                        </td>
                    @endforeach
                    @for ($i = $chunk->count(); $i < 3; $i++)
                        <td class="post-card empty"></td>
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <div class="comment">
        <h2>> Comentarios</h2>
        @if($comments->isEmpty())
            <p class="italic">Este usuario no ha comentado.</p>
        @else
            <div class="comments-table">
                <table>
                    <thead>
                    <tr>
                        <th>ID Comentarios</th>
                        <th>Comentarios</th>
                        <th>ID Recetas</th>
                        <th>Recetas</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>{{ $comment->post->id }}</td>
                            <td>{{ $comment->post->title }}</td>
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
            </div>
        @endif
    </div>
</body>
</html>
