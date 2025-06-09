<?php

namespace App\Http\Controllers\Configuracion\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoProductoRequest;
use App\Models\TipoProducto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoProductoController extends Controller
{
    protected $tipoProducto;
    public function __construct()
    {
        $this->tipoProducto = new TipoProducto();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoProducto::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tpro_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Almacen/TipoProducto/index', [
            'items' => $items,
            'headers' => $this->tipoProducto->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoProductoRequest $request)
    {
        $data = $request->all();
        TipoProducto::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoProductoRequest $request, TipoProducto $tipoProducto)
    {
        $data = $request->all();
        $tipoProducto->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoProducto $tipoProducto)
    {
        $tipoProducto->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = TipoProducto::select('tpro_id', 'tpro_nombre')
                ->where('tpro_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }

    public function forSelect()
    {
        $results = TipoProducto::select('tpro_id as value', 'tpro_nombre as title')
            ->get();

        return response()->json($results);
    }
}
