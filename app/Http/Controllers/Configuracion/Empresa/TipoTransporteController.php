<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoTransporteRequest;
use App\Models\TipoTransporte;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoTransporteController extends Controller
{


    protected $tipoTransporte;
    public function __construct()
    {
        $this->tipoTransporte = new TipoTransporte();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoTransporte::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('ttra_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoTransporte/index', [
            'items' => $items,
            'headers' => $this->tipoTransporte->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoTransporteRequest $request)
    {
        $data = $request->all();
        TipoTransporte::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoTransporteRequest $request, TipoTransporte $tipoTransporte)
    {
        $data = $request->all();
        $tipoTransporte->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoTransporte $tipoTransporte)
    {
        $tipoTransporte->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
