<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación de incidencia</title>
</head>

<body>
    <p>Se ha {{ $operacion }} la incidencia con ID: {{ $incidencia->id }}</p>
    <h3>Detalles: </h3>
    <ul>
        <li>Creador: {{ auth()->user()->nombre_completo }}</li>
        <li>Tipo: {{ $incidencia->tipo }}</li>
        @isset($incidencia->subtipo->subtipo_nombre)
            <li>Subtipo: {{ $incidencia->subtipo->subtipo_nombre }}</li>
        @endisset
        @isset($incidencia->subtipo->sub_subtipo)
            <li>Sub-Subtipo: {{ $incidencia->subtipo->sub_subtipo }}</li>
        @endisset
        <li>Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
        @isset($incidencia->fecha_cierre)
            <li>Fecha de cierre: {{ $incidencia->fecha_cierre }}</li>
        @endisset
        <li>Estado: {{ $incidencia->estado }}</li>
        <li>Prioridad: {{ $incidencia->prioridad }}</li>
        @isset($incidencia->duracion)
            <li>Duración: {{ $incidencia->duracion }}</li>
        @endisset
        @isset($incidencia->equipo->aula->codigo)
            <li>Aula: {{ $incidencia->equipo->aula->codigo }}</li>
        @endisset
        @isset($incidencia->equipo->etiqueta)
            <li>Etiqueta: {{ $incidencia->equipo->etiqueta }}</li>
        @endisset
        @isset($incidencia->equipo->modelo)
            <li>Modelo: {{ $incidencia->equipo->modelo }}</li>
        @endisset
        <li>Descripción: {{ $incidencia->descripcion }}</li>
        @isset($incidencia->actuaciones)
            <li>Actuaciones: {{ $incidencia->actuaciones }}</li>
        @endisset
    </ul>
</body>

</html>
