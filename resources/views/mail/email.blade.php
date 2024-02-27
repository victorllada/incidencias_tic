<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>
    <p>Se ha {{ $operacion }} la incidencia con ID: {{ $incidencia->id }}</p>
    <h3>Detalles: </h3>
    <ul>
        <li>Creador: {{ auth()->user()->nombre_completo }}</li>
    </ul>
</body>

</html>
