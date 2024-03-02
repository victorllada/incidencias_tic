<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incidencias abiertas</title>
</head>

<body>

    @forelse($usuariosConIncidenciasAbiertas as $usuario)
        <table>
            <thead>
                <tr>
                    <th colspan="8" style="background-color: #0e97e9; font-family: Arial, Helvetica, sans-serif">{{ $usuario->nombre_completo }}</th>
                </tr>
                <tr>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">ID</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Creador</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Tipo</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Subtipo</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Fecha creación</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Prioridad</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Estado</th>
                    <th style="background-color: #bae2fd; font-family: Arial, Helvetica, sans-serif">Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuario->incidenciasAbiertas as $incidencia)
                    <tr>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->id }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->creador->nombre_completo }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->tipo }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->subtipo->subtipo_nombre }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->fecha_creacion }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->prioridad }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->estado }}</td>
                        <td style="font-family: Arial, Helvetica, sans-serif">{{ $incidencia->descripcion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Sin incidencias abiertas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        <h1>No hay incidencias abiertas</h1>
    @endforelse

</body>

</html>
