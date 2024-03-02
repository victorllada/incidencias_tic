<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estadísticas</title>
</head>

<body>
    <!-- Tabla total incidencias por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Total de
                    incidencias por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($totalPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias resueltas por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias resueltas por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    Resueltas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resueltasPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_resueltas }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias abiertas por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias abiertas por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    Abiertas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abiertasPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_abiertas }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias cerradas por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias cerradas por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    Cerradas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cerradasPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_cerradas }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias asignadas por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias asignadas por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    asignadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignadasPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_asignadas }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias asignadas por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias es proceso por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total en
                    proceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enProcesoPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_enProceso }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla total incidencias enviadas a INFORTEC por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias enviadas a INFORTEC por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    ennviada a INFORTEC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enviadaAInfortecPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">
                        {{ $item->total_enviadaAInfortec }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla conteo de incidencias por estado y tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Conteo
                    de incidencias por estado y tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Estado</th>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conteoPorEstadoYTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->estado }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla incidencias por departamento -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">
                    Incidencias por Departamento</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Departamento</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total
                    Incidencias</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incidenciasPorDepartamento as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->departamento }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">{{ $item->total_incidencias }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla tiempo promedio por tipo -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Tiempo
                    promedio de resolución por tipo</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th colspan="2" style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tiempo
                    Promedio de Resolución (minutos)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiempoPromedioPorTipo as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->tipo }}</td>
                    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif">
                        {{ $item->tiempo_promedio_resolucion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla conteo de incidencias por estado y responsable -->
    <table>
        <thead>
            <tr>
                <th colspan="3" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Conteo
                    de incidencias por estado y responsable</th>
            </tr>
            <tr>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Responsable</th>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Estado</th>
                <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conteoPorEstadoYResponsable as $item)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->responsable_nombre }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->estado }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
