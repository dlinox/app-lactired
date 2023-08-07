<?php

namespace App\Http\Controllers\Configuracion\Trabajador;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradoInstruccionRequest;
use App\Models\GradoInstruccion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradoInstruccionController extends Controller
{
    protected $gradoInstruccion;
    public function __construct()
    {
        $this->gradoInstruccion = new GradoInstruccion();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = GradoInstruccion::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('gins_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Trabajador/GradoInstruccion/index', [
            'items' => $items,
            'headers' => $this->gradoInstruccion->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(GradoInstruccionRequest $request)
    {
        $data = $request->all();
        GradoInstruccion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(GradoInstruccionRequest $request, GradoInstruccion $gradoInstruccione)
    {
        $data = $request->all();
        $gradoInstruccione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(GradoInstruccion $gradoInstruccione)
    {
        $gradoInstruccione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
