<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estadísticas</title>
</head>

<body>
    <h2>Total de incidencias por tipo</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($totalPorTipo as $item)
                <tr>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Incidencias resueltas por tipo</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Total Resueltas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resueltasPorTipo as $item)
                <tr>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->total_resueltas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Incidencias abiertas por tipo</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Total Abiertas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abiertasPorTipo as $item)
                <tr>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->total_abiertas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Tiempo promedio de resolución por tipo</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Tiempo Promedio de Resolución (minutos)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiempoPromedioPorTipo as $item)
                <tr>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->tiempo_promedio_resolucion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
