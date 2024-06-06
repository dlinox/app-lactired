<?php

use App\Http\Controllers\Acopio\AcopioController;
use App\Http\Controllers\Acopio\PagoController;
use App\Http\Controllers\Almacen\InsumoController;
use App\Http\Controllers\Almacen\ProductoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientController;
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

use Barryvdh\Snappy\Facades\SnappyPdf;


Route::get('/snappy-pdf', function () {

    $courses = [
        [
            'id' => 1,
            'course' => 'Math to the power of 10 and beyond the universe of the infinite and beyond  forever and ever',
            'cycle' => 'I',
            'credits' => 4,
            'hours' => 64,
            'teacher' => 'John Doe Jane Doe Jane Doe'
        ],
        [
            'id' => 2,
            'course' => 'Science',
            'cycle' => 'II',
            'credits' => 3,
            'hours' => 48,
            'teacher' => 'Jane Doe'
        ],
        [
            'id' => 3,
            'course' => 'History',
            'cycle' => 'III',
            'credits' => 2,
            'hours' => 32,
            'teacher' => 'John Smith'
        ],
        [
            'id' => 4,
            'course' => 'Geography',
            'cycle' => 'IV',
            'credits' => 3,
            'hours' => 48,
            'teacher' => 'Jane Smith'
        ],
        [
            'id' => 5,
            'course' => 'English',
            'cycle' => 'V',
            'credits' => 4,
            'hours' => 64,
            'teacher' => 'John Doe'
        ],
        [
            'id' => 6,
            'course' => 'Spanish',
            'cycle' => 'VI',
            'credits' => 3,
            'hours' => 48,
            'teacher' => 'Jane Doe'
        ],
        [
            'id' => 7,
            'course' => 'Art',
            'cycle' => 'VII',
            'credits' => 2,
            'hours' => 32,
            'teacher' => 'John Smith'
        ],
        [
            'id' => 8,
            'course' => 'Music',
            'cycle' => 'VIII',
            'credits' => 3,
            'hours' => 48,
            'teacher' => 'Jane Smith'
        ],
        [
            'id' => 9,
            'course' => 'Physical Education',
            'cycle' => 'IX',
            'credits' => 4,
            'hours' => 64,
            'teacher' => 'John Doe'
        ],

    ];

    // obtener  la vsita desde la ruta views.pdf.test.snappy

    // incluir cabezera 

    $pdf = SnappyPdf::loadView('pdf.test.snappy', compact('courses'));

    $pdf->setOption('enable-javascript', true);
    $pdf->setOption('no-stop-slow-scripts', true);

    $pdf->setOptions([
        
        'margin-right' => '0.5cm',
        'margin-top' => '4cm',
        'margin-bottom' => '0.5cm',
        'margin-left' => '0.5cm',
        'encoding' => 'UTF-8',
        'orientation' => 'landscape',
        'page-size' => 'a4',
        //paginacion
        'footer-right' => '[page] / [toPage]',
        'header-html' => view('pdf.test._header'),
    ]);

    // Obtén el contenido del PDF como una cadena de texto
    $pdfContent = $pdf->output();

    // Devuelve el PDF al navegador con los encabezados adecuados
    return response($pdfContent, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="test.pdf"');
});


























Route::inertia('/403', 'Errors/Error403')->name('error.403');

Route::name('auth.')->prefix('')->group(function () {
    Route::get('/login',  [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in');
    Route::delete('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out');

    Route::get('/registro-cliente',  [ClientController::class, 'index'])->name('registro.cliente')->middleware('guest');
    Route::post('/registrar-cliente',  [ClientController::class, 'store'])->name('registrar.cliente')->middleware('guest');
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
    Route::post('permisos', [RolController::class, 'asignarPermisos']);


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
