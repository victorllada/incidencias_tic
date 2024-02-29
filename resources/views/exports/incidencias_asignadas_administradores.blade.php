<!DOCTYPE html>
<html>

<head>
    <title>Incidencias asignadas</title>
</head>

<body>

    @forelse($usuariosConIncidenciasAsignadas as $usuario)
        <table>
            <thead>
                <tr>
                    <th colspan="7"><strong>{{ $usuario->nombre_completo }}</strong></th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Creador</th>
                    <th>Tipo</th>
                    <th>Subtipo</th>
                    <th>Fecha creación</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Duración</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuario->incidenciasAsignadas as $incidencia)
                    <tr>
                        <td>{{ $incidencia->id }}</td>
                        <td>{{ $incidencia->creador->nombre_completo }}</td>
                        <td>{{ $incidencia->tipo }}</td>
                        <td>{{ $incidencia->subtipo->subtipo_nombre }}</td>
                        <td>{{ $incidencia->fecha_creacion }}</td>
                        <td>{{ $incidencia->prioridad }}</td>
                        <td>{{ $incidencia->estado }}</td>
                        <td>{{ $incidencia->duracion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Sin incidencias asignadas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        <h1>No hay incidencias asignadas a administradores</h1>
    @endforelse

</body>

</html>
