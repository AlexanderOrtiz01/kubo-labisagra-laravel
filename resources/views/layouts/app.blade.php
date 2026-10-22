<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Inventario') · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="barra">
        <a class="marca" href="{{ route('productos.index') }}">
            <span class="logo" aria-hidden="true">LB</span>
            <span><strong>{{ config('app.name') }}</strong><small>Sistema de inventario · 4 sucursales</small></span>
        </a>
        <a class="boton" href="{{ route('productos.create') }}">+ Nuevo producto</a>
    </header>

    <main class="contenido">
        @if (session('ok'))
            <p class="aviso aviso-ok" role="status">{{ session('ok') }}</p>
        @endif
        @yield('contenido')
    </main>

    @php($info = \App\Http\Controllers\PlataformaController::info())
    <footer class="pie">
        <span class="pie-titulo">Desplegado en Kubo PaaS · plan básico</span>
        <ul class="stack">
            @foreach ($info as $nombre => $valor)
                <li><b>{{ $nombre }}</b> {{ $valor }}</li>
            @endforeach
        </ul>
    </footer>
</body>
</html>
