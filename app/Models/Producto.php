<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public const CATEGORIAS = ['Herramientas', 'Construcción', 'Electricidad', 'Fontanería', 'Pinturas', 'Tornillería'];

    public const SUCURSALES = ['San Miguel Centro', 'San Miguel Roosevelt', 'Usulután', 'La Unión'];

    protected $fillable = ['codigo', 'nombre', 'categoria', 'sucursal', 'precio', 'existencias'];

    protected $casts = ['precio' => 'decimal:2', 'existencias' => 'integer'];
}
