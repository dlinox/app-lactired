<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoEspecializacionRequest;
use App\Models\TipoEspecializacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoEspecializacionController extends Controller
{
    protected $tipoEspecializacion;
    public function __construct()
    {
        $this->tipoEspecializacion = new TipoEspecializacion();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoEspecializacion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tesp_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoEspecializacion/index', [
            'items' => $items,
            'headers' => $this->tipoEspecializacion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoEspecializacionRequest $request)
    {
        $data = $request->all();
        TipoEspecializacion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoEspecializacionRequest $request, TipoEspecializacion $tipoEspecializacione)
    {
        $data = $request->all();
        $tipoEspecializacione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoEspecializacion $tipoEspecializacione)
    {
        $tipoEspecializacione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
