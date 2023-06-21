<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstitucionRequest;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    protected $institucion;
    public function __construct()
    {
        $this->institucion = new Institucion();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Institucion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('inst_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/Institucion/index', [
            'items' => $items,
            'headers' => $this->institucion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(InstitucionRequest $request)
    {
        $data = $request->all();
        Institucion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(InstitucionRequest $request, Institucion $institucione)
    {
        $data = $request->all();
        $institucione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Institucion $institucione)
    {
        $institucione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Institucion::select('inst_id', 'inst_nombre')
                ->where('inst_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
