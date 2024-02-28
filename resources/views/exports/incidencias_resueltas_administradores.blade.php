<!DOCTYPE html>
<html>

<head>
    <title>Incidencias resueltas</title>
</head>

<body>

    @foreach($usuariosConIncidenciasResueltas as $usuario)
    <table>
        <thead>
            <tr>
                <th colspan="7"><strong>{{ $usuario->nombre_completo }}</strong></th>
            </tr>
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
            @forelse($usuario->incidenciasResueltas as $incidencia)
                <tr>
                    <td>{{ $incidencia->id }}</td>
                    <td>{{ $incidencia->creador->nombre_completo }}</td>
                    <td>{{ $incidencia->tipo }}</td>
                    <td>{{ $incidencia->subtipo->subtipo_nombre }}</td>
                    <td>{{ $incidencia->fecha_creacion }}</td>
                    <td>{{ $incidencia->prioridad }}</td>
                    <td>{{ $incidencia->estado }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Sin incidencias resueltas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endforeach

</body>

</html>
