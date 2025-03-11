<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cajero</title>
</head>
<body>
    <h1>Sucursal 1</h1>
    <ul>
        @foreach ( $cajaGeneral as $denominaciones )
            <li>a</li>
        @endforeach

    </ul>
    <button>Abrir caja</button>
    <button>Cambiar cheque</button> <br>
    <button>Agregar billetes</button>
    <button>corte de caja</button> <br>
    <a href="verCaja">VerCaja</a>
</body>
</html>