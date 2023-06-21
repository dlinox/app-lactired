<?php

namespace App\Http\Controllers\Configuracion\Trabajador;

use App\Http\Controllers\Controller;
use App\Http\Requests\CargoRequest;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CargoController extends Controller
{
    protected $cargo;
    public function __construct()
    {
        $this->cargo = new Cargo();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Cargo::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('carg_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Trabajador/Cargo/index', [
            'items' => $items,
            'headers' => $this->cargo->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(CargoRequest $request)
    {
        $data = $request->all();
        Cargo::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(CargoRequest $request, Cargo $cargo)
    {
        $data = $request->all();
        $cargo->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
