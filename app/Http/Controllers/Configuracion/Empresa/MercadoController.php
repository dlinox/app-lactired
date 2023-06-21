<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\MercadoRequest;
use App\Models\Mercado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MercadoController extends Controller
{
    protected $mercado;
    public function __construct()
    {
        $this->mercado = new Mercado();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Mercado::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('merc_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Configuracion/Empresa/Mercado/index', [
            'items' => $items,
            'headers' => $this->mercado->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(MercadoRequest $request)
    {
        $data = $request->all();
        Mercado::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(MercadoRequest $request, Mercado $mercado)
    {
        $data = $request->all();
        $mercado->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Mercado $mercado)
    {
        $mercado->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
