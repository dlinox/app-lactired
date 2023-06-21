<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    protected $proveedor;
    public function __construct()
    {
        $this->proveedor = new Proveedor();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Proveedor::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('prov_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Compra/Proveedor/index', [
            'items' => $items,
            'headers' => $this->proveedor->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(ProveedorRequest $request)
    {
        $data = $request->all();
        Proveedor::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        $data = $request->all();
        $proveedor->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Proveedor::select('prov_id', DB::raw("CONCAT(prov_nombres,' ', prov_paterno,' ',prov_materno, ' | ', prov_dni ) AS proveedor"))
                ->orWhere('prov_nombres', 'like', '%' . $searchTerm . '%')
                ->orWhere('prov_paterno', 'like', '%' . $searchTerm . '%')
                ->orWhere('prov_materno', 'like', '%' . $searchTerm . '%')
                ->orWhere('prov_dni', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }

}
