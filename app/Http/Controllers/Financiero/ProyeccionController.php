<?php

namespace App\Http\Controllers\Financiero;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoInsumo;
use App\Models\Proyeccion;
use App\Models\ProyeccionDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProyeccionController extends Controller
{
    protected $user;
    protected $proyeccion;
    public function __construct()
    {
        $this->proyeccion = new Proyeccion();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $anio = $request->input('anio', date('Y'));

        $planta = $this->user->user_plan_id;

        $existProyeccion =  $this->upsertProjectionForYearAndPlan($anio, $planta);

        if (!$existProyeccion) {
            return redirect()->back()->withErrors(['error' => 'No se pudo crear o actualizar la proyección.']);
        }

        $items = Proyeccion::join('proyeccion_detalles', 'proyeccion_detalles.proyd_proy_id', '=', 'proyecciones.proy_id')
            ->join('productos', 'productos.prod_id', '=', 'proyeccion_detalles.proyd_prod_id')
            ->where('proyecciones.proy_plan_id', $planta)
            ->where('proyecciones.proy_anio', $anio)
            ->orderBy('productos.prod_nombre', 'asc')
            ->get()
            ->map(function ($item) {
                $costoProduccion = (float) (
                    ProductoInsumo::where('pinsu_prod_id', $item->prod_id)
                    ->selectRaw('SUM(pinsu_cantidad * pinsu_precio) as total')
                    ->value('total') ?? 0
                );

                $precioVenta = (float) $item->prod_precio_venta;
                $margen = $precioVenta - $costoProduccion;
                $porcentajeMargen = $precioVenta > 0
                    ? number_format(($margen / $precioVenta) * 100, 1) . '%'
                    : '%';

                return [
                    'proy_id' => $item->proy_id,
                    'prod_id' => $item->prod_id,
                    'proyd_id' => $item->proyd_id,
                    'prod_nombre' => $item->prod_nombre,
                    'prod_precio_venta' => ($precioVenta),
                    'prod_costo_produccion' => $costoProduccion,
                    'proy_margen_ganancia' => $margen,
                    'proy_margen_ganancia_porcentaje' => $porcentajeMargen,

                    'proyd_cantidad_mensual' => collect(explode(',', $item->proyd_cantidad_mensual))
                        ->map(fn($v) => is_numeric($v) ? (float) $v : 0)
                        ->toArray(),
                ];
            });

        return Inertia::render('Financiero/Proyeccion/index', [
            'items' => $items,
            'anio' => $anio,
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $proyecciones = $request->proyecciones;

            foreach ($proyecciones as $proy) {
                ProyeccionDetalle::where('proyd_id', $proy['proyd_id'])
                    ->update([
                        'proyd_cantidad_mensual' => implode(',', $proy['proyd_cantidad_mensual']),
                    ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Elemento guardado correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    /**
     * Crea o actualiza la proyección y sus detalles para un año y plan dados.
     */
    private function upsertProjectionForYearAndPlan($year, $planId)
    {
        try {
            DB::beginTransaction();

            // Verificar si ya existe una proyección para el año y plan especificados
            $existingProjection = Proyeccion::where('proy_plan_id', $planId)
                ->where('proy_anio', $year)
                ->first();

            if ($existingProjection) {
                // Si existe una proyección, se inserta o se actualiza los detalles
                $proyeccionDetalles = ProyeccionDetalle::where('proyd_proy_id', $existingProjection->proy_id)->get();
                $productos = Producto::where('prod_plan_id', $planId)->get();
                foreach ($productos as $producto) {
                    $detalle = $proyeccionDetalles->firstWhere('proyd_prod_id', $producto->prod_id);
                    if (!$detalle) {
                        // Si no existe el detalle, se crea uno nuevo
                        ProyeccionDetalle::create([
                            'proyd_proy_id' => $existingProjection->proy_id,
                            'proyd_prod_id' => $producto->prod_id,
                            'proyd_cantidad_mensual' => '0,0,0,0,0,0,0,0,0,0,0,0',
                        ]);
                    }
                }
            }

            // Si no existe una proyección, se crea una nueva
            if (!$existingProjection) {
                $newProjection = Proyeccion::create([
                    'proy_plan_id' => $planId,
                    'proy_anio' => $year,
                ]);

                // Crear detalles de proyección para cada producto
                $productos = Producto::where('prod_plan_id', $planId)->get();
                foreach ($productos as $producto) {
                    ProyeccionDetalle::create([
                        'proyd_proy_id' => $newProjection->proy_id,
                        'proyd_prod_id' => $producto->prod_id,
                        'proyd_cantidad_mensual' => '0,0,0,0,0,0,0,0,0,0,0,0',
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new \Exception('Error al crear o actualizar la proyección: ' . $th->getMessage());

            // return $th->getMessage();
        }
    }
}
