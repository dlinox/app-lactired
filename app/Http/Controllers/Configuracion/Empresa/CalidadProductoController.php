<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalidadProductoRequest;
use App\Models\CalidadProducto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalidadProductoController extends Controller
{
    protected $calidadProducto;
    public function __construct()
    {
        $this->calidadProducto = new CalidadProducto();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = CalidadProducto::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('cpro_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Configuracion/Empresa/CalidadProducto/index', [
            'items' => $items,
            'headers' => $this->calidadProducto->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(CalidadProductoRequest $request)
    {
        $data = $request->all();
        CalidadProducto::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(CalidadProductoRequest $request, CalidadProducto $calidadProducto)
    {
        $data = $request->all();
        $calidadProducto->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(CalidadProducto $calidadProducto)
    {
        $calidadProducto->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = CalidadProducto::select('cpro_id', 'cpro_nombre')
                ->where('cpro_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
