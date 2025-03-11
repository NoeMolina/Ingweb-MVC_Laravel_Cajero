<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contenido Caja</title>
</head>
<body>
    <h1>Sucursal 1</h1>
    <label>Contenido de Caja general</label>
    <ul>
        @foreach ( $cajaGeneral as $caja )
        <li>{{ $caja->Denominacion }}: {{ $caja->cant_disponible }}</li>
        @endforeach

    </ul>
    <a href="/">Regresar</a>
</body>
</html>