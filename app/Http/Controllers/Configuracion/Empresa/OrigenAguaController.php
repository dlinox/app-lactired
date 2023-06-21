<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrigenAguaRequest;
use App\Models\OrigenAgua;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrigenAguaController extends Controller
{
    protected $origenAgua;
    public function __construct()
    {
        $this->origenAgua = new OrigenAgua();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = OrigenAgua::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('oagu_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/OrigenAgua/index', [
            'items' => $items,
            'headers' => $this->origenAgua->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(OrigenAguaRequest $request)
    {
        $data = $request->all();
        OrigenAgua::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(OrigenAguaRequest $request, OrigenAgua $origenAgua)
    {
        $data = $request->all();
        $origenAgua->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(OrigenAgua $origenAgua)
    {
        $origenAgua->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
