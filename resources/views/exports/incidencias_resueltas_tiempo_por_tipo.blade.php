<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias tipos tiempo</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Tipo de Incidencia</th>
                <th>Tiempo de Resolución</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiposIncidenciasConTiempos as $tipo => $tiempo)
                <tr>
                    <td>{{ $tipo }}</td>
                    <td>{{ $tiempo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
