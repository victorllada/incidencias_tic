<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias asignadas</title>
</head>

<body>

    @forelse($usuariosConIncidenciasAsignadas as $usuario)
        <table>
            <thead>
                <tr>
                    <th colspan="8" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif"><strong>{{ $usuario->nombre_completo }}</strong></th>
                </tr>
                <tr>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">ID</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Creador</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Subtipo</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Fecha creación</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Fecha cierre</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Estado</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Duración</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuario->incidenciasAsignadas as $incidencia)
                    <tr>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->id }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->creador->nombre_completo }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->tipo }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->subtipo->subtipo_nombre }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->fecha_creacion }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->fecha_cierre }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->estado }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->duracion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="font-family: Arial, Helvetica, sans-serif">Sin incidencias asignadas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        <h1>No hay incidencias asignadas a administradores</h1>
    @endforelse

</body>

</html>
