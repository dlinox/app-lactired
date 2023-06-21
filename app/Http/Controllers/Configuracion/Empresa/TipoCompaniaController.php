<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoCompaniaRequest;
use App\Models\TipoCompania;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoCompaniaController extends Controller
{
    protected $tipoCompania;
    public function __construct()
    {
        $this->tipoCompania = new TipoCompania();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoCompania::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tcomp_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoCompania/index', [
            'items' => $items,
            'headers' => $this->tipoCompania->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoCompaniaRequest $request)
    {
        $data = $request->all();
        TipoCompania::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoCompaniaRequest $request, TipoCompania $tipoCompania)
    {
        $data = $request->all();
        $tipoCompania->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoCompania $tipoCompania)
    {
        $tipoCompania->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = TipoCompania::select('tcomp_id', 'tcomp_nombre')
                ->where('tcomp_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
