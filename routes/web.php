<?php

use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/productos');
Route::resource('productos', ProductoController::class)->except('show');
Route::get('/salud', [PlataformaController::class, 'salud']);
