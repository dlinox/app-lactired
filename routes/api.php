<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('plantas', [ApiController::class, 'getPlantas']);
Route::get('planta/{planta}', [ApiController::class, 'getPlanta']);

Route::get('planta/productos/{planta}', [ApiController::class, 'getProductosPlanta']);


Route::get('productos', [ApiController::class, 'getProductos']);
Route::get('tipo-productos', [ApiController::class, 'getTipoProductos']);

Route::get('insumos', [ApiController::class, 'getInsumos']);
