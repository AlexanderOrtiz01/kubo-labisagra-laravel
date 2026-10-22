<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

// Inventario inicial (solo si la tabla está vacía: se ejecuta en cada arranque del contenedor)
class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        if (Producto::exists()) {
            return;
        }

        $filas = [
            ['HER-001', 'Martillo de uña 16 oz mango de fibra', 'Herramientas', 'San Miguel Centro', 8.75, 34],
            ['HER-014', 'Juego de destornilladores 6 piezas', 'Herramientas', 'San Miguel Roosevelt', 6.50, 21],
            ['CON-102', 'Cemento gris tipo GU, bolsa 42.5 kg', 'Construcción', 'San Miguel Centro', 9.10, 180],
            ['CON-118', 'Varilla corrugada 3/8" x 6 m', 'Construcción', 'Usulután', 4.25, 260],
            ['ELE-201', 'Cable THHN calibre 12, rollo 100 m', 'Electricidad', 'San Miguel Roosevelt', 52.00, 12],
            ['ELE-230', 'Tomacorriente doble polarizado', 'Electricidad', 'La Unión', 1.95, 0],
            ['FON-305', 'Tubo PVC 1/2" x 6 m presión', 'Fontanería', 'Usulután', 3.40, 95],
            ['PIN-410', 'Pintura látex blanco hueso, galón', 'Pinturas', 'San Miguel Centro', 17.90, 40],
            ['TOR-502', 'Tornillo gypsum 1" punta fina, caja 1000', 'Tornillería', 'La Unión', 7.80, 18],
        ];

        foreach ($filas as [$codigo, $nombre, $categoria, $sucursal, $precio, $existencias]) {
            Producto::create(compact('codigo', 'nombre', 'categoria', 'sucursal', 'precio', 'existencias'));
        }
    }
}
