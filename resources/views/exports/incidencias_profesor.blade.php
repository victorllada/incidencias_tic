<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias profesor</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">ID</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Subtipo</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Fecha creación</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Fecha cierre</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Estado</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Descripción</th>
                <th style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">Responsable</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incidencias as $incidencia)
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->id }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->tipo }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->subtipo->subtipo_nombre }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->fecha_creacion }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->fecha_cierre }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->estado }}</td>
                    <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->descripcion }}</td>
                    @isset($incidencia->responsable->nombre_completo)
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->responsable->nombre_completo }}</td>
                    @else
                        <td style="font-family: Arial, Helvetica, sans-serif"></td>
                    @endisset
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="font-family: Arial, Helvetica, sans-serif">No hay incidencias</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
