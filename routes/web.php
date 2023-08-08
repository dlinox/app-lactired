<?php

use App\Http\Controllers\Acopio\AcopioController;
use App\Http\Controllers\Acopio\PagoController;
use App\Http\Controllers\Almacen\InsumoController;
use App\Http\Controllers\Almacen\ProductoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Compra\CompraController;
use App\Http\Controllers\Compra\ProveedorController;

use App\Http\Controllers\Configuracion\Almacen\TipoProductoController;
use App\Http\Controllers\Configuracion\Almacen\UnidadMedidaController;
use App\Http\Controllers\Configuracion\Empresa\CalidadProductoController;
use App\Http\Controllers\Configuracion\Empresa\CombustibleController;
use App\Http\Controllers\Configuracion\Empresa\InstitucionController;
use App\Http\Controllers\Configuracion\Empresa\MercadoController;
use App\Http\Controllers\Configuracion\Empresa\NivelCapacitacionController;
use App\Http\Controllers\Configuracion\Empresa\OrigenAguaController;
use App\Http\Controllers\Configuracion\Empresa\TipoCertificacionController;
use App\Http\Controllers\Configuracion\Empresa\TipoCompaniaController;
use App\Http\Controllers\Configuracion\Empresa\TipoComprobanteController;
use App\Http\Controllers\Configuracion\Empresa\TipoEmpresaController;
use App\Http\Controllers\Configuracion\Empresa\TipoEspecializacionController;
use App\Http\Controllers\Configuracion\Empresa\TipoFinanciamientoController;
use App\Http\Controllers\Configuracion\Empresa\TipoMaquinariaController;
use App\Http\Controllers\Configuracion\Empresa\TipoMovilidadController;
use App\Http\Controllers\Configuracion\Empresa\TipoTransporteController;

use App\Http\Controllers\Configuracion\Trabajador\CargoController;
use App\Http\Controllers\Configuracion\Trabajador\GradoInstruccionController;
use App\Http\Controllers\Configuracion\Trabajador\ProfesionController;
use App\Http\Controllers\Configuracion\Trabajador\TipoDocumentoController;

use App\Http\Controllers\Venta\VentaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Planta\EmpleadoController;
use App\Http\Controllers\Planta\PlantaController;
use App\Http\Controllers\Seguridad\RolController;
use App\Http\Controllers\Seguridad\UsuarioController;
use App\Http\Controllers\Venta\ClienteController;

use Illuminate\Support\Facades\Route;


Route::inertia('/403', 'Errors/Error403')->name('error.403');

Route::name('auth.')->prefix('')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in');
    Route::delete('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out');
});

Route::middleware(['auth', 'can:dashboard'])->name('admin.')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');

    Route::name('reportes.')->prefix('reportes')->group(function () {
        Route::get('ventas', [DashboardController::class, 'reporteVentas'])->name('reporteVentas');
        Route::get('compras', [DashboardController::class, 'reporteCompras'])->name('reporteCompras');
        Route::get('acopio', [DashboardController::class, 'reporteAcopio'])->name('reporteAcopio');
    });
});


Route::middleware(['auth', 'can:menu-de-acopio'])->name('acopio.')->prefix('acopio')->group(function () {
    Route::resource('', AcopioController::class);

    Route::get('', [AcopioController::class, 'index'])->name('index');
    Route::post('', [AcopioController::class, 'store'])->name('store');
    Route::delete('{compra}', [AcopioController::class, 'destroy'])->name('destroy');
    Route::get('create', [AcopioController::class, 'create'])->name('create');
    // Route::put('{planta}', [AcopioController::class, 'update'])->name('update');
    // Route::get('show/{planta}', [AcopioController::class, 'show'])->name('show');

    Route::resource('pagos', PagoController::class);
    Route::get('pagos/detalle/{id}', [PagoController::class, 'getDetallePagoProveedor'])->name('pago.detalle');
});

Route::middleware(['auth', 'can:menu-de-compras'])->name('compras.')->prefix('compras')->group(function () {
    Route::post('', [CompraController::class, 'store'])->name('store');
    Route::get('', [CompraController::class, 'index'])->name('index');
    Route::delete('{compra}', [CompraController::class, 'destroy'])->name('destroy');
    Route::get('create', [CompraController::class, 'create'])->name('create');
    Route::resource('proveedores', ProveedorController::class);
});

Route::middleware(['auth', 'can:menu-de-ventas'])->name('ventas.')->prefix('ventas')->group(function () {
    Route::post('', [VentaController::class, 'store'])->name('store');
    Route::get('', [VentaController::class, 'index'])->name('index');
    Route::delete('{venta}', [VentaController::class, 'destroy'])->name('destroy');

    Route::get('create', [VentaController::class, 'create'])->name('create');
    Route::resource('clientes', ClienteController::class);
});

Route::middleware(['auth', 'can:menu-de-almacen'])->name('almacen.')->prefix('almacen')->group(function () {
    Route::resource('productos', ProductoController::class);
    Route::resource('insumos', InsumoController::class);
});

Route::middleware('auth')->name('plantas.')->prefix('plantas')->group(function () {
    Route::get('', [PlantaController::class, 'index'])->name('index')->middleware(['can:menu-de-planta']);
    Route::post('', [PlantaController::class, 'store'])->name('store');
    
    Route::get('all', [PlantaController::class, 'getAll'])->name('all');
    Route::post('change', [PlantaController::class, 'changePlant'])->name('change');

    Route::put('{planta}', [PlantaController::class, 'update'])->name('update');
    Route::delete('{planta}', [PlantaController::class, 'destroy'])->name('destroy');
    Route::get('create', [PlantaController::class, 'create'])->name('create');
    Route::get('show/{planta}', [PlantaController::class, 'show'])->name('show');
});


Route::middleware(['auth', 'can:menu-de-empleados'])->resource('empleados', EmpleadoController::class);


Route::middleware(['auth', 'can:menu-de-configuracion'])->name('config.')->prefix('config')->group(function () {
    Route::name('empresa.')->prefix('empresa')->group(function () {
        Route::resource('instituciones', InstitucionController::class);
        Route::resource('mercados', MercadoController::class);
        Route::resource('tipo-empresas', TipoEmpresaController::class);
        Route::resource('tipo-companias', TipoCompaniaController::class)->except([
            'show'
        ]);

        Route::resource('nivel-capacitaciones', NivelCapacitacionController::class)->parameters([
            'nivel-capacitaciones' => 'nivel_capacitacion',
        ]);

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
        Route::resource('grado-instrucciones', GradoInstruccionController::class);
        Route::resource('profesiones', ProfesionController::class);
    });
});

Route::middleware(['auth', 'can:menu-de-seguridad'])->name('seguridad.')->prefix('seguridad')->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RolController::class);
    // Route::resource('backups', Co::class);
});

Route::middleware(['auth'])->name('autocomplete.')->prefix('autocomplete')->group(function () {
    Route::get('tipo-companias', [TipoCompaniaController::class, 'autocomplete'])->name('tipo-companias');
    Route::get('tipo-instituciones', [InstitucionController::class, 'autocomplete'])->name('tipo-instituciones');
    Route::get('nivel-capacitaciones', [NivelCapacitacionController::class, 'autocomplete'])->name('nivel-capacitaciones');
    Route::get('calidad-productos', [CalidadProductoController::class, 'autocomplete'])->name('calidad-productos');

    Route::get('tipo-productos', [TipoProductoController::class, 'autocomplete'])->name('tipo-productos');

    Route::get('plantas', [PlantaController::class, 'autocomplete'])->name('plantas');

    Route::get('unidades-medida', [UnidadMedidaController::class, 'autocomplete'])->name('unidades-medida');

    //venta
    Route::get('clientes', [ClienteController::class, 'autocomplete'])->name('clientes');
    Route::get('productos', [ProductoController::class, 'autocomplete'])->name('productos');

    //compra
    Route::get('proveedores', [ProveedorController::class, 'autocomplete'])->name('proveedores');
    Route::get('insumos', [InsumoController::class, 'autocomplete'])->name('insumos');

    Route::get('ubigeos', [Controller::class, 'ubigeoAutocomplete'])->name('ubigeos');
});

Route::get('demo-pdf', [PagoController::class, 'generarPDF']);
