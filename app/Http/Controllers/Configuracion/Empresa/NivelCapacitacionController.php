<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\NivelCapacitacionRequest;
use App\Models\NivelCapacitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NivelCapacitacionController extends Controller
{

    protected $nivelCapacitacion;
    public function __construct()
    {
        $this->nivelCapacitacion = new NivelCapacitacion();
    }

    public function index(Request $request)
    {


        $perPage = $request->input('perPage', 10);
        $query = NivelCapacitacion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('ncap_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/NivelCapacitacion/index', [
            'items' => $items,
            'headers' => $this->nivelCapacitacion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(NivelCapacitacionRequest $request)
    {
        $data = $request->all();
        NivelCapacitacion::create($data);
        return redirect()->back()->with('success', 'Nivel de capacitación creada exitosamente.');
    }

    public function update(NivelCapacitacionRequest $request, NivelCapacitacion $nivelCapacitacion)
    {
        $data = $request->all();
        $nivelCapacitacion->update($data);
        return redirect()->back()->with('success', 'Nivel de capacitación actualizada exitosamente.');
    }

    public function destroy(NivelCapacitacion $nivelCapacitacion)
    {
        $nivelCapacitacion->delete();
        return redirect()->back()->with('success', 'Nivel de capacitación eliminada exitosamente.');
    }
}
