<?php

namespace App\Http\Controllers\Configuracion\Trabajador;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoDocumentoRequest;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoDocumentoController extends Controller
{
    protected $tipoDocumento;
    public function __construct()
    {
        $this->tipoDocumento = new TipoDocumento();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoDocumento::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tdoc_nombre', 'like', '%' . $searchTerm . '%');
            $query->where('tdoc_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Trabajador/TipoDocumento/index', [
            'items' => $items,
            'headers' => $this->tipoDocumento->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoDocumentoRequest $request)
    {
        $data = $request->all();
        TipoDocumento::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoDocumentoRequest $request, TipoDocumento $tipoDocumento)
    {
        $data = $request->all();
        $tipoDocumento->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoDocumento $tipoDocumento)
    {
        $tipoDocumento->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
