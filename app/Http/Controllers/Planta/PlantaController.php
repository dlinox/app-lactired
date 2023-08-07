<?php

namespace App\Http\Controllers\Planta;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantaRequest;
use App\Models\Empleado;
use App\Models\Insumo;
use App\Models\Planta;
use App\Models\PlantaEmpleado;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PlantaController extends Controller
{

    protected $user;
    protected $planta;
    protected $plantaId;

    public function __construct()
    {
        $this->planta = new Planta();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->plantaId = $this->user->hasRole('Super Admin') ? null : $this->user->user_plan_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Planta::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('plan_razon_social', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Planta/index', [
            'items' => $items,
            'headers' => $this->planta->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function show(Planta $planta)
    {
        $planta =  Planta::find($this->plantaId);
        return Inertia::render(
            'Planta/show',
            [
                'planta' => $planta,
                'empleados' => PlantaEmpleado::where('plem_plan_id', $this->plantaId)->with('empleado')->get(),
                'productos' => Producto::where('prod_plan_id', $this->plantaId)->get(),
                'insumos' => Insumo::where('insu_plan_id', $this->plantaId)->get(),
            ]
        );
    }

    public function store(PlantaRequest $request)
    {
        $data = $request->all();
        Planta::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function create()
    {
        return Inertia::render('Planta/create');
    }

    public function update(PlantaRequest $request, Planta $planta)
    {
        $data = $request->all();
        $planta->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Planta $planta)
    {
        $planta->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function getAll()
    {
        $plantas =  Planta::select('plan_id as id', 'plan_razon_social as name')->get();
        return response()->json($plantas);
    }

    public function changePlant(Request $request)
    {
        $user = User::find($this->user->id);
        $user->user_plan_nombre = $request->name;
        $user->user_plan_id = $request->id;
        $user->save();
        return redirect()->back()->with('success', 'Se cambio de planta con exito.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Planta::select('plan_id', 'plan_razon_social')
                ->orwhere('plan_razon_social', 'like', '%' . $searchTerm . '%')
                ->orwhere('plan_ruc', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
