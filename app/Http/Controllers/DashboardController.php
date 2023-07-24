<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Planta;
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

    public function index()
    {
        return Inertia::render('Home');
    }

    public function reporteVentas(Request $request)
    {
        $year = $request->has('anio') ? $request->anio : date('Y');
        $ventas = Venta::select('vent_plan_id', DB::raw('SUM(vent_total) as total_ventas'), DB::raw('MONTH(vent_fecha) as month'), DB::raw('MONTHNAME(vent_fecha) as mes'))
            ->where('vent_plan_id', $this->plantaId)
            ->whereYear('vent_fecha', $year)
            ->groupBy(DB::raw('vent_plan_id, MONTH(vent_fecha), MONTHNAME(vent_fecha)'))
            ->get();

        $data = (object)[
            'labels' => $ventas->pluck('mes')->toArray(),
            'data' => $ventas->pluck('total_ventas')->toArray(),
        ];

        return response()->json($data);
    }

    public function reporteAcopio(Request $request)
    {

        $year = $request->has('anio') ? $request->anio : date('Y');
        $compras = Compra::select(DB::raw('SUM(comp_total) as total'), DB::raw('MONTH(comp_fecha) as month'), DB::raw('MONTHNAME(comp_fecha) as mes'))
            ->where('comp_plan_id', $this->plantaId)
            ->where('comp_tipo', 0)
            ->whereYear('comp_fecha', $year)
            ->groupBy(DB::raw('MONTH(comp_fecha), MONTHNAME(comp_fecha)'))
            ->get();

        $data = (object)[
            'labels' => $compras->pluck('mes')->toArray(),
            'data' => $compras->pluck('total')->toArray(),
        ];

        return response()->json($data);
    }

    public function reporteCompras(Request $request)
    {

        $year = $request->has('anio') ? $request->anio : date('Y');
        $compras = Compra::select(DB::raw('SUM(comp_total) as total'), DB::raw('MONTH(comp_fecha) as month'), DB::raw('MONTHNAME(comp_fecha) as mes'))
            ->where('comp_plan_id', $this->plantaId)
            ->where('comp_tipo', 1)
            ->whereYear('comp_fecha', $year)
            ->groupBy(DB::raw('MONTH(comp_fecha), MONTHNAME(comp_fecha)'))
            ->get();

        $data = (object)[
            'labels' => $compras->pluck('mes')->toArray(),
            'data' => $compras->pluck('total')->toArray(),
        ];

        return response()->json($data);
    }
}
