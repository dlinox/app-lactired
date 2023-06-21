<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantaRequest;
use App\Models\Planta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantaController extends Controller
{
    protected $planta;
    public function __construct()
    {
        $this->planta = new Planta();
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

        return Inertia::render('Configuracion/Planta/index', [
            'items' => $items,
            'headers' => $this->planta->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(PlantaRequest $request)
    {
        $data = $request->all();
        Planta::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function create()
    {
        return Inertia::render('Configuracion/Planta/create');
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
