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

    <!-- Mostrar mensajes de éxito -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar mensajes de fallo -->
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <ul>
        @if(isset($resultado))
            @foreach ($resultado as $item)
                <li>Denominación: {{ $item['denominacion'] }}, Cantidad: {{ $item['cantidad'] }}</li>
            @endforeach
        @endif
    </ul>

    <form action="{{ route('abrirCaja')}}" method="POST">
        @csrf
        <button type="submit">Abrir caja</button>
    </form>
    <form action="{{route('agregarBilletes')}}" method="POST">
        @csrf
        <button type="submit">Agregar billetes</button>
    </form>
    <form action="{{route('canjearCheque')}}" method="POST">
        @csrf
        <label for="importe">Importe</label>
        <input type="text" id="importe" name="importe" pattern="\d+" title="Solo están permitidos valores numéricos" required value="{{ old('importe') }}">
        <button type="submit">Canjear cheque</button>
    </form>

    <button>corte de caja</button> <br>
    <a href='{{route('verCaja')}}'>VerCaja</a>
</body>

</html>