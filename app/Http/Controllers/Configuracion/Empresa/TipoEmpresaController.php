<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoEmpresaRequest;
use App\Models\TipoEmpresa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoEmpresaController extends Controller
{
    protected $tipoEmpresa;
    public function __construct()
    {
        $this->tipoEmpresa = new TipoEmpresa();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoEmpresa::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('temp_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoEmpresa/index', [
            'items' => $items,
            'headers' => $this->tipoEmpresa->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoEmpresaRequest $request)
    {
        $data = $request->all();
        TipoEmpresa::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoEmpresaRequest $request, TipoEmpresa $tipoEmpresa)
    {
        $data = $request->all();
        $tipoEmpresa->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoEmpresa $tipoEmpresa)
    {
        $tipoEmpresa->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
