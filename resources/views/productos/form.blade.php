@extends('layouts.app')

@section('titulo', $producto->exists ? 'Editar '.$producto->codigo : 'Nuevo producto')

@section('contenido')
    <h1>{{ $producto->exists ? 'Editar producto '.$producto->codigo : 'Nuevo producto' }}</h1>

    @if ($errors->any())
        <ul class="aviso aviso-error" role="alert">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    @endif

    <form class="tarjeta formulario" method="post"
          action="{{ $producto->exists ? route('productos.update', $producto) : route('productos.store') }}">
        @csrf
        @if ($producto->exists) @method('PUT') @endif

        <label>Código <input name="codigo" value="{{ old('codigo', $producto->codigo) }}" maxlength="20" required placeholder="HER-020"></label>
        <label class="ancho">Nombre <input name="nombre" value="{{ old('nombre', $producto->nombre) }}" maxlength="120" required></label>
        <label>Categoría
            <select name="categoria" required>
                @foreach (\App\Models\Producto::CATEGORIAS as $c)
                    <option @selected(old('categoria', $producto->categoria) === $c)>{{ $c }}</option>
                @endforeach
            </select>
        </label>
        <label>Sucursal
            <select name="sucursal" required>
                @foreach (\App\Models\Producto::SUCURSALES as $s)
                    <option @selected(old('sucursal', $producto->sucursal) === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </label>
        <label>Precio (USD) <input name="precio" type="number" step="0.01" min="0" value="{{ old('precio', $producto->precio) }}" required></label>
        <label>Existencias <input name="existencias" type="number" min="0" value="{{ old('existencias', $producto->existencias) }}" required></label>

        <div class="botones ancho">
            <a class="boton boton-sec" href="{{ route('productos.index') }}">Cancelar</a>
            <button class="boton">{{ $producto->exists ? 'Guardar cambios' : 'Registrar producto' }}</button>
        </div>
    </form>
@endsection
