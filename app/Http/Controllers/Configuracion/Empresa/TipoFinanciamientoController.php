<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoFinanciamientoRequest;
use App\Models\TipoFinanciamiento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoFinanciamientoController extends Controller
{
    protected $tipoFinanciamiento;
    public function __construct()
    {
        $this->tipoFinanciamiento = new TipoFinanciamiento();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoFinanciamiento::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tfin_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoFinanciamiento/index', [
            'items' => $items,
            'headers' => $this->tipoFinanciamiento->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoFinanciamientoRequest $request)
    {
        $data = $request->all();
        TipoFinanciamiento::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoFinanciamientoRequest $request, TipoFinanciamiento $tipoFinanciamiento)
    {
        $data = $request->all();
        $tipoFinanciamiento->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoFinanciamiento $tipoFinanciamiento)
    {
        $tipoFinanciamiento->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }


}
