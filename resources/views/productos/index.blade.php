@extends('layouts.app')

@section('contenido')
    <section class="resumen">
        <div><span>Productos</span><strong>{{ $resumen['productos'] }}</strong></div>
        <div><span>Unidades en bodega</span><strong>{{ number_format($resumen['unidades']) }}</strong></div>
        <div><span>Agotados</span><strong class="{{ $resumen['agotados'] ? 'alerta' : '' }}">{{ $resumen['agotados'] }}</strong></div>
        <div><span>Valor del inventario</span><strong>${{ number_format($resumen['valor'], 2) }}</strong></div>
    </section>

    <form class="buscar" method="get" action="{{ route('productos.index') }}">
        <input type="search" name="buscar" value="{{ $buscar }}" placeholder="Buscar por código, nombre o categoría" aria-label="Buscar">
        <button class="boton boton-sec">Buscar</button>
        @if ($buscar !== '')<a href="{{ route('productos.index') }}">Limpiar</a>@endif
    </form>

    <div class="tabla-envoltura">
        <table>
            <thead>
                <tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Sucursal</th><th class="num">Precio</th><th class="num">Existencias</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($productos as $p)
                    <tr>
                        <td><code>{{ $p->codigo }}</code></td>
                        <td>{{ $p->nombre }}</td>
                        <td><span class="etiqueta">{{ $p->categoria }}</span></td>
                        <td>{{ $p->sucursal }}</td>
                        <td class="num">${{ number_format($p->precio, 2) }}</td>
                        <td class="num {{ $p->existencias === 0 ? 'alerta' : '' }}">{{ $p->existencias === 0 ? 'Agotado' : $p->existencias }}</td>
                        <td class="acciones">
                            <a href="{{ route('productos.edit', $p) }}">Editar</a>
                            <form method="post" action="{{ route('productos.destroy', $p) }}" onsubmit="return confirm('¿Eliminar {{ $p->codigo }}?')">
                                @csrf @method('DELETE')
                                <button class="enlace-peligro">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="vacio">No hay productos{{ $buscar !== '' ? ' que coincidan con la búsqueda' : '' }}.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($productos->hasPages())
        <nav class="paginas">
            @if ($productos->previousPageUrl())<a href="{{ $productos->previousPageUrl() }}">← Anterior</a>@endif
            <span>Página {{ $productos->currentPage() }} de {{ $productos->lastPage() }}</span>
            @if ($productos->nextPageUrl())<a href="{{ $productos->nextPageUrl() }}">Siguiente →</a>@endif
        </nav>
    @endif
@endsection
