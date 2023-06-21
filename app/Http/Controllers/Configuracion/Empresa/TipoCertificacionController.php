<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoCertificacionRequest;
use App\Models\TipoCertificacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoCertificacionController extends Controller
{
    protected $tipoCertificacion;
    public function __construct()
    {
        $this->tipoCertificacion = new TipoCertificacion();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoCertificacion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tesp_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoCertificacion/index', [
            'items' => $items,
            'headers' => $this->tipoCertificacion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoCertificacionRequest $request)
    {
        $data = $request->all();
        TipoCertificacion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoCertificacionRequest $request, TipoCertificacion $tipoCertificacione)
    {
        $data = $request->all();
        $tipoCertificacione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoCertificacion $tipoCertificacione)
    {
        $tipoCertificacione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
