<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoMovilidadRequest;
use App\Models\TipoMovilidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoMovilidadController extends Controller
{

    protected $tipoMovilidad;
    public function __construct()
    {
        $this->tipoMovilidad = new TipoMovilidad();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoMovilidad::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tmov_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoMovilidad/index', [
            'items' => $items,
            'headers' => $this->tipoMovilidad->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoMovilidadRequest $request)
    {
        $data = $request->all();
        TipoMovilidad::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoMovilidadRequest $request, TipoMovilidad $tipoMovilidade)
    {
        $data = $request->all();
        $tipoMovilidade->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoMovilidad $tipoMovilidade)
    {
        $tipoMovilidade->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
