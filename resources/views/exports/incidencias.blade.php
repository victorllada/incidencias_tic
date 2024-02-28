<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Subtipo</th>
                <th>Fecha creación</th>
                <th>Prioridad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incidencias as $incidencia)
                <tr>
                    <td>{{ $incidencia->id }}</td>
                    <td>{{ $incidencia->creador->nombre_completo }}</td>
                    <td>{{ $incidencia->tipo }}</td>
                    <td>{{ $incidencia->subtipo->subtipo_nombre }}</td>
                    <td>{{ $incidencia->fecha_creacion }}</td>
                    <td>{{ $incidencia->prioridad }}</td>
                    <td>{{ $incidencia->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
