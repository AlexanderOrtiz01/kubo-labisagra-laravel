<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim((string) $request->query('buscar', ''));
        $productos = Producto::query()
            ->when($buscar !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('nombre', 'like', "%{$buscar}%")
                ->orWhere('codigo', 'like', "%{$buscar}%")
                ->orWhere('categoria', 'like', "%{$buscar}%")))
            ->orderBy('codigo')
            ->paginate(10)
            ->withQueryString();

        $resumen = [
            'productos' => Producto::count(),
            'unidades' => (int) Producto::sum('existencias'),
            'agotados' => Producto::where('existencias', 0)->count(),
            'valor' => (float) Producto::selectRaw('COALESCE(SUM(precio * existencias), 0) AS v')->value('v'),
        ];

        return view('productos.index', compact('productos', 'buscar', 'resumen'));
    }

    public function create()
    {
        return view('productos.form', ['producto' => new Producto(['existencias' => 0])]);
    }

    public function store(Request $request)
    {
        $producto = Producto::create($this->validar($request));

        return redirect()->route('productos.index')->with('ok', "Producto {$producto->codigo} registrado.");
    }

    public function edit(Producto $producto)
    {
        return view('productos.form', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($this->validar($request, $producto));

        return redirect()->route('productos.index')->with('ok', "Producto {$producto->codigo} actualizado.");
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('ok', "Producto {$producto->codigo} eliminado.");
    }

    private function validar(Request $request, ?Producto $producto = null): array
    {
        return $request->validate([
            'codigo' => ['required', 'string', 'max:20', Rule::unique('productos')->ignore($producto)],
            'nombre' => ['required', 'string', 'max:120'],
            'categoria' => ['required', Rule::in(Producto::CATEGORIAS)],
            'sucursal' => ['required', Rule::in(Producto::SUCURSALES)],
            'precio' => ['required', 'numeric', 'min:0', 'max:99999'],
            'existencias' => ['required', 'integer', 'min:0', 'max:1000000'],
        ], [], [
            'codigo' => 'código', 'precio' => 'precio', 'existencias' => 'existencias',
        ]);
    }
}
