<?php

namespace App\Http\Controllers\Configuracion\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadMedidaRequest;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnidadMedidaController extends Controller
{
    protected $unidadesMedida;
    public function __construct()
    {
        $this->unidadesMedida = new UnidadMedida();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = UnidadMedida::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('udem_nombre', 'like', '%' . $searchTerm . '%');
            $query->where('udem_simbolo', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Almacen/UnidadMedida/index', [
            'items' => $items,
            'headers' => $this->unidadesMedida->headers,
            'filters' => [
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(UnidadMedidaRequest $request)
    {
        $data = $request->all();
        UnidadMedida::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(UnidadMedidaRequest $request, UnidadMedida $unidadesMedida)
    {
        $data = $request->all();
        $unidadesMedida->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(UnidadMedida $unidadesMedida)
    {
        $unidadesMedida->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = UnidadMedida::select('umed_id', 'umed_nombre')
                ->where('umed_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }

}
