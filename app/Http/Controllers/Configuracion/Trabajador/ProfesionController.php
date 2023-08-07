<?php

namespace App\Http\Controllers\Configuracion\Trabajador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfesionRequest;
use App\Models\Profesion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfesionController extends Controller
{
    protected $profesion;
    public function __construct()
    {
        $this->profesion = new Profesion();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Profesion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('prof_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Trabajador/Profesion/index', [
            'items' => $items,
            'headers' => $this->profesion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(ProfesionRequest $request)
    {
        $data = $request->all();
        Profesion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(ProfesionRequest $request, Profesion $profesione)
    {
        $data = $request->all();
        $profesione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Profesion $profesione)
    {
        $profesione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
