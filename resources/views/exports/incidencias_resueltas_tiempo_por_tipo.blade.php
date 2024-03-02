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
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Tipo de Incidencia</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Tiempo de Resolución</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiposIncidenciasConTiempos as $tipo => $tiempo)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $tipo }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $tiempo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
