{{-- resources/views/errors/404.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found</title>

    <!-- Fuente similar a la de Laravel por defecto -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 20px 0 20px;
            text-align: center;
        }

        .message {
            font-size: 18px;
            padding: 10px 20px;
            text-align: left;
            line-height: 1.4;
        }

        .small {
            font-size: 13px;
            color: #4b5563;
            margin-top: 10px;
        }

        a {
            color: #636b6f;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div>
            <div style="display:flex; align-items:center;">
                <div class="code">404</div>
                <div class="message">
                    <div><strong>Not Found</strong></div>
                    <div class="small">Lo sentimos, la página que buscas no existe.</div>

                    {{-- Aquí mostramos la ruta/URL que no existe --}}
                    <div style="margin-top:12px;">
					    <strong>Ruta solicitada:</strong>
					    <div class="small" title="{{ request()->getPathInfo() }}">
					        {{ request()->getPathInfo() }}
					    </div>
					</div>

                    {{-- Links útiles (opcional) --}}
                    <div style="margin-top:14px;">
                        <a href="{{ url()->previous() }}">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
