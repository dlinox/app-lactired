<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Inversion;
use App\Models\Planta;
use App\Models\Producto;
use App\Models\ProductoInsumo;
use App\Models\Proyeccion;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{

    protected $user;
    protected $planta;
    protected $plantaId;

    protected $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    public function __construct()
    {
        $this->planta = new Planta();
        DB::statement("SET lc_time_names = 'es_PE'");

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->plantaId = $this->user->hasRole('Super Admin') ? null : $this->user->user_plan_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {

        $anio = $request->has('anio') ? $request->anio : date('Y');

        $activosFijos = Inversion::where('inver_plan_id', $this->plantaId)
            ->where('inver_tipo', 'Activo Fijo')
            ->sum('inver_total');

        $capitalTrabajo = Inversion::where('inver_plan_id', $this->plantaId)
            ->where('inver_tipo', 'Capital de Trabajo')
            // inver_periodo = 2025-06
            ->where('inver_periodo', 'like', $anio . '-%')
            ->sum('inver_total');

        /*
            SELECT pr.prod_id, pd.proyd_cantidad_mensual, pr.prod_precio_venta
FROM proyecciones py
JOIN proyeccion_detalles pd  ON py.proy_id = pd.proyd_proy_id
JOIN productos pr ON pr.prod_id =  pd.proyd_prod_id
WHERE py.proy_anio = '2025'
	AND py.proy_plan_id = 2;
            */
        $proyeccionVentas = Proyeccion::select(
            'prod_id',
            'proyd_cantidad_mensual',
            'prod_precio_venta'
        )
            ->join('proyeccion_detalles', 'proyeccion_detalles.proyd_proy_id', '=', 'proyecciones.proy_id')
            ->join('productos', 'productos.prod_id', '=', 'proyeccion_detalles.proyd_prod_id')
            ->where('proyecciones.proy_plan_id', $this->plantaId)
            ->where('proyecciones.proy_anio', $anio)
            ->get()
            ->map(function ($item) {
                $cantidadesMes = collect(explode(',', $item->proyd_cantidad_mensual))
                    ->map(fn($v) => is_numeric($v) ? (float)$v : 0)
                    ->toArray();

                $productoPrecio = (float)$item->prod_precio_venta;

                $totalProyeccion = collect($cantidadesMes)
                    ->sum(fn($cantidad) => $cantidad * $productoPrecio);

                return (float)$totalProyeccion;
            })->sum();

        $proyeccionCompras = Proyeccion::select(
            'prod_id',
            'proyd_cantidad_mensual',
        )
            ->join('proyeccion_detalles', 'proyeccion_detalles.proyd_proy_id', '=', 'proyecciones.proy_id')
            ->join('productos', 'productos.prod_id', '=', 'proyeccion_detalles.proyd_prod_id')
            ->where('proyecciones.proy_plan_id', $this->plantaId)
            ->where('proyecciones.proy_anio', $anio)
            ->get()
            ->map(function ($item) {
                $cantidadesMes = collect(explode(',', $item->proyd_cantidad_mensual))
                    ->map(fn($v) => is_numeric($v) ? (float)$v : 0)
                    ->toArray();

                $productoCostoProduccion = (float) (
                    ProductoInsumo::where('pinsu_prod_id', $item->prod_id)
                    ->selectRaw('SUM(pinsu_cantidad * pinsu_precio) as total')
                    ->value('total') ?? 0
                );
                $productoPrecio = $productoCostoProduccion;

                $totalProyeccion = collect($cantidadesMes)
                    ->sum(fn($cantidad) => $cantidad * $productoPrecio);

                return (float)$totalProyeccion;
            })->sum();

        $ventas = Venta::where('vent_plan_id', $this->plantaId)
            ->whereYear('vent_fecha', $anio)
            ->sum('vent_total');

        $compras = Compra::where('comp_plan_id', $this->plantaId)
            ->where('comp_tipo', 1) // Tipo 1 para compras
            ->whereYear('comp_fecha', $anio)
            ->sum('comp_total');

        return Inertia::render('Home', [
            'anio' => (int)$anio,
            'activosFijos' => (float)$activosFijos,
            'capitalTrabajo' => (float)$capitalTrabajo,
            'proyeccionVentas' => $proyeccionVentas,
            'proyeccionCompras' => $proyeccionCompras,
            'ventas' => (float)$ventas,
            'compras' => (float)$compras,
        ]);
    }

    public function reporteVentas(Request $request)
    {
        $year = $request->has('anio') ? $request->anio : \Carbon\Carbon::now()->year;

        $ventas = Venta::select(
            'vent_plan_id',
            DB::raw('SUM(vent_total) as total_ventas'),
            DB::raw('MONTH(vent_fecha) as month')
        )
            ->where('vent_plan_id', $this->plantaId)
            ->whereYear('vent_fecha', $year)
            ->groupBy('vent_plan_id', DB::raw('MONTH(vent_fecha)'))
            ->get()
            ->keyBy('month'); // Ahora sí, después del get()

        $labels = [];
        $data = [];

        foreach ($this->meses as $num => $nombre) {
            $labels[] = $nombre;
            $data[] = isset($ventas[$num]) ? (float)$ventas[$num]->total_ventas : 0;
        }

        $proyecciones = Proyeccion::select('proyd_cantidad_mensual', 'proyd_prod_id')
            ->join('proyeccion_detalles', 'proyeccion_detalles.proyd_proy_id', '=', 'proyecciones.proy_id')
            ->where('proyecciones.proy_plan_id', $this->plantaId)
            ->where('proyecciones.proy_anio', $year)
            ->get()->map(function ($item) {

                $cantidadesMes = collect(explode(',', $item->proyd_cantidad_mensual))
                    ->map(fn($v) => is_numeric($v) ? (float) $v : 0)
                    ->toArray();

                $producto = Producto::select('prod_precio_venta')->where('prod_id', $item->proyd_prod_id)->first();
                $productoPrecio = $producto ? (float)$producto->prod_precio_venta : 0;

                $preciosMes = collect($cantidadesMes)
                    ->map(fn($cantidad) => $cantidad * $productoPrecio)
                    ->toArray();


                return (object)[
                    'precios' => $preciosMes,
                ];
            });

        $proyeccionesAnio = array_fill(0, 12, 0);

        foreach ($proyecciones as $proyeccion) {
            foreach ($proyeccion->precios as $index => $precio) {
                $proyeccionesAnio[$index] += $precio;
            }
        }

        $response = (object)[
            'labels' => collect($this->meses)->values()->toArray(),
            'data' => [
                'Ventas (S/.)' => $data,
                'Proyecciones (S/.)' => $proyeccionesAnio,
            ],
        ];

        return response()->json($response);
    }


    public function reporteCompras(Request $request)
    {

        $year = $request->has('anio') ? $request->anio : date('Y');

        $compras = Compra::select(DB::raw('SUM(comp_total) as total'), DB::raw('MONTH(comp_fecha) as month'), DB::raw('MONTHNAME(comp_fecha) as mes'))
            ->where('comp_plan_id', $this->plantaId)
            ->where('comp_tipo', 1)
            ->whereYear('comp_fecha', $year)
            ->groupBy(DB::raw('MONTH(comp_fecha), MONTHNAME(comp_fecha)'))
            ->get()
            ->keyBy('month'); // Indexamos por número de mes

        $labels = [];
        $data = [];
        foreach ($this->meses as $num => $nombre) {
            $labels[] = $nombre;
            $data[] = isset($compras[$num]) ? (float)$compras[$num]->total : 0;
        }
        $proyecciones = Proyeccion::select('proyd_cantidad_mensual', 'proyd_prod_id')
            ->join('proyeccion_detalles', 'proyeccion_detalles.proyd_proy_id', '=', 'proyecciones.proy_id')
            ->where('proyecciones.proy_plan_id', $this->plantaId)
            ->where('proyecciones.proy_anio', $year)
            ->get()->map(function ($item) {

                $cantidadesMes = collect(explode(',', $item->proyd_cantidad_mensual))
                    ->map(fn($v) => is_numeric($v) ? (float) $v : 0)
                    ->toArray();


                $costoProduccion = (float) (
                    ProductoInsumo::where('pinsu_prod_id', $item->proyd_prod_id)
                    ->selectRaw('SUM(pinsu_cantidad * pinsu_precio) as total')
                    ->value('total') ?? 0
                );

                $preciosMes = collect($cantidadesMes)
                    ->map(fn($cantidad) => $cantidad * $costoProduccion)
                    ->toArray();

                return (object)[
                    'precios' => $preciosMes,
                ];
            });

        $proyeccionesAnio = array_fill(0, 12, 0);
        foreach ($proyecciones as $proyeccion) {
            foreach ($proyeccion->precios as $index => $precio) {
                $proyeccionesAnio[$index] += $precio;
            }
        }


        $response = (object)[
            'labels' => $compras->pluck('mes')->toArray(),
            'data' => [
                'Compras (S/.)' => $data,
                'Proyecciones (S/.)' => $proyeccionesAnio,
            ]
        ];

        return response()->json($response);
    }

    public function reporteAcopio(Request $request)
    {

        $year = $request->has('anio') ? $request->anio : date('Y');

        $compras = Compra::select(
            DB::raw('SUM(comp_total) as total'),
            DB::raw('MONTH(comp_fecha) as month'),
            DB::raw('MONTHNAME(comp_fecha) as mes')
        )
            ->where('comp_plan_id', $this->plantaId)
            ->where('comp_tipo', 0)
            ->whereYear('comp_fecha', $year)
            ->groupBy(DB::raw('MONTH(comp_fecha), MONTHNAME(comp_fecha)'))
            ->get()
            ->keyBy('month'); // Indexamos por número de mes

        $labels = [];
        $data = [];

        foreach ($this->meses as $num => $nombre) {
            $labels[] = $nombre;
            $data[] = isset($compras[$num]) ? (float)$compras[$num]->total : 0;
        }

        $response = (object)[
            'labels' => $labels,
            'data' => [
                'Acopio (S/.)' => $data,
            ]
        ];

        return response()->json($response);
    }
}
