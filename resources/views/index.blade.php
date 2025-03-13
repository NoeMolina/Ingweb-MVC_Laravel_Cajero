<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cajero</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Sucursal 1</h1>

        @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <ul class="list-disc list-inside mb-6">
            @if(isset($resultado))
                @foreach ($resultado as $item)
                    <li class="bg-gray-200 p-2 rounded mb-2">Denominación: {{ $item['denominacion'] }}, Cantidad: {{ $item['cantidad'] }}</li>
                @endforeach
            @endif
        </ul>

        <form action="{{ route('abrirCaja') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Abrir caja</button>
        </form>
        <form action="{{ route('agregarBilletes') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar billetes</button>
        </form>
        <form action="{{ route('canjearCheque') }}" method="POST" class="mb-6">
            @csrf
            <label for="importe" class="block text-gray-700 font-medium mb-2">Importe</label>
            <input type="text" id="importe" name="importe" pattern="\d+" title="Solo están permitidos valores numéricos" required value="{{ old('importe') }}" class="w-full p-2 border border-gray-300 rounded mb-4">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Canjear cheque</button>
        </form>

        <button class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Corte de caja</button>
        <br><br>
        <a href='{{ route('verCaja') }}' class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Ver Caja</a>
    </div>
</body>

</html>