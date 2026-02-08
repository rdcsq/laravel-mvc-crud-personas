<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;

Route::get('/', [PersonaController::class, 'index']);

Route::get('/agregar', [PersonaController::class, 'mostrarFormularioAgregar']);
Route::post('/agregar', [PersonaController::class, 'agregar']);

Route::get('/{rfc}', [PersonaController::class, 'recuperar']);
Route::post('/{rfc}', [PersonaController::class, 'editar']);
Route::delete('/{rfc}', [PersonaController::class, 'eliminar']);
