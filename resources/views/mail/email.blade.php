<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación de incidencia</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', 'Arial' sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8fafc;
        }

        .card {
            background-color: #e0f0fe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #075185;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        h2,
        h3 {
            margin-bottom: 15px;
            font-weight: bold;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        li strong {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h2>¡Se ha {{ $operacion }} la incidencia con ID: {{ $incidencia->id }}!</h2>
        </div>
        <div class="card-body">
            <h3>Detalles:</h3>
            <ul>
                <li><strong>Creador:</strong> {{ auth()->user()->nombre_completo }}</li>
                <li><strong>Tipo:</strong> {{ $incidencia->tipo }}</li>
                @isset($incidencia->subtipo->subtipo_nombre)
                    <li><strong>Subtipo:</strong> {{ $incidencia->subtipo->subtipo_nombre }}</li>
                @endisset
                @isset($incidencia->subtipo->sub_subtipo)
                    <li><strong>Sub-Subtipo:</strong> {{ $incidencia->subtipo->sub_subtipo }}</li>
                @endisset
                <li><strong>Fecha de creación:</strong> {{ $incidencia->fecha_creacion }}</li>
                @isset($incidencia->fecha_cierre)
                    <li><strong>Fecha de cierre:</strong> {{ $incidencia->fecha_cierre }}</li>
                @endisset
                <li><strong>Estado:</strong> {{ $incidencia->estado }}</li>
                <li><strong>Prioridad:</strong> {{ $incidencia->prioridad }}</li>
                @isset($incidencia->duracion)
                    <li><strong>Duración:</strong> {{ $incidencia->duracion }}</li>
                @endisset
                @isset($incidencia->equipo->aula->codigo)
                    <li><strong>Aula:</strong> {{ $incidencia->equipo->aula->codigo }}</li>
                @endisset
                @isset($incidencia->equipo->etiqueta)
                    <li><strong>Etiqueta:</strong> {{ $incidencia->equipo->etiqueta }}</li>
                @endisset
                @isset($incidencia->equipo->modelo)
                    <li><strong>Modelo:</strong> {{ $incidencia->equipo->modelo }}</li>
                @endisset
                <li><strong>Descripción:</strong> {{ $incidencia->descripcion }}</li>
                @isset($incidencia->actuaciones)
                    <li><strong>Actuaciones:</strong> {{ $incidencia->actuaciones }}</li>
                @endisset
            </ul>
        </div>
    </div>
</body>

</html>
