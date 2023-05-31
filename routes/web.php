<?php

use App\Http\Controllers\Configuracion\Almacen\TipoProductoController;
use App\Http\Controllers\Configuracion\Almacen\UnidadMedidaController;
use App\Http\Controllers\Configuracion\Empresa\CalidadProductoController;
use App\Http\Controllers\Configuracion\Empresa\CombustibleController;
use App\Http\Controllers\Configuracion\Empresa\InstitucionController;
use App\Http\Controllers\Configuracion\Empresa\MercadoController;
use App\Http\Controllers\Configuracion\Empresa\NivelCapacitacionController;
use App\Http\Controllers\Configuracion\Empresa\OrigenAguaController;
use App\Http\Controllers\Configuracion\Empresa\TipoCertificacionController;
use App\Http\Controllers\Configuracion\Empresa\TipoComprobanteController;
use App\Http\Controllers\Configuracion\Empresa\TipoEmpresaController;
use App\Http\Controllers\Configuracion\Empresa\TipoEspecializacionController;
use App\Http\Controllers\Configuracion\Empresa\TipoFinanciamientoController;
use App\Http\Controllers\Configuracion\Empresa\TipoMaquinariaController;
use App\Http\Controllers\Configuracion\Empresa\TipoMovilidadController;
use App\Http\Controllers\Configuracion\Empresa\TipoTransporteController;
use App\Http\Controllers\Configuracion\PlantaController;
use App\Http\Controllers\Configuracion\Trabajador\CargoController;
use App\Http\Controllers\Configuracion\Trabajador\TipoDocumentoController;
use App\Http\Controllers\Configuracion\UsuarioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Home');
});


Route::name('config.')->prefix('config')->group(function () {
    Route::resource('plantas', PlantaController::class);
    Route::resource('usuarios', UsuarioController::class);

    Route::name('empresa.')->prefix('empresa')->group(function () {
        Route::resource('instituciones', InstitucionController::class);
        Route::resource('mercados', MercadoController::class);
        Route::resource('tipo-empresas', TipoEmpresaController::class);
        Route::resource('nivel-capacitaciones', NivelCapacitacionController::class)->parameters([
            'nivel-capacitaciones' => 'nivel_capacitacion',
        ]);;
        Route::resource('calidad-productos', CalidadProductoController::class);
        Route::resource('tipo-especializaciones', TipoEspecializacionController::class);
        Route::resource('tipo-certificaciones', TipoCertificacionController::class);
        Route::resource('tipo-transportes', TipoTransporteController::class);
        Route::resource('tipo-movilidades', TipoMovilidadController::class);
        Route::resource('combustibles', CombustibleController::class);
        Route::resource('tipo-maquinarias', TipoMaquinariaController::class);
        Route::resource('tipo-financiamientos', TipoFinanciamientoController::class);
        Route::resource('tipo-comprobantes', TipoComprobanteController::class);
        Route::resource('origen-aguas', OrigenAguaController::class);
    });

    Route::name('almacen.')->prefix('almacen')->group(function () {
        Route::resource('tipo-productos', TipoProductoController::class);
        Route::resource('unidades-medida', UnidadMedidaController::class);
    });

    Route::name('trabajador.')->prefix('trabajador')->group(function () {
        Route::resource('cargos', CargoController::class);
        Route::resource('tipo-documentos', TipoDocumentoController::class);
    });
});
