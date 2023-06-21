<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoMaquinariaRequest;
use App\Models\TipoMaquinaria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoMaquinariaController extends Controller
{
    protected $tipoMaquinaria;
    public function __construct()
    {
        $this->tipoMaquinaria = new TipoMaquinaria();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoMaquinaria::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tmaq_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoMaquinaria/index', [
            'items' => $items,
            'headers' => $this->tipoMaquinaria->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoMaquinariaRequest $request)
    {
        $data = $request->all();
        TipoMaquinaria::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoMaquinariaRequest $request, TipoMaquinaria $tipoMaquinaria)
    {
        $data = $request->all();
        $tipoMaquinaria->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoMaquinaria $tipoMaquinaria)
    {
        $tipoMaquinaria->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
