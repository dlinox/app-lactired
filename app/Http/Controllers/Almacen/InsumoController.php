<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsumoRequest;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsumoController extends Controller
{
    protected $insumo;
    public function __construct()
    {
        $this->insumo = new Insumo();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Insumo::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('insu_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Almacen/Insumo/index', [
            'items' => $items,
            'headers' => $this->insumo->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(InsumoRequest $request)
    {
        $data = $request->all();
        Insumo::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(InsumoRequest $request, Insumo $insumo)
    {
        $data = $request->all();
        $insumo->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Insumo::where('insu_nombre', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
