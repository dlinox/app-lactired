<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClienteController extends Controller
{
    protected $cliente;
    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Cliente::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('clie_nombres', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Venta/Cliente/index', [
            'items' => $items,
            'headers' => $this->cliente->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(ClienteRequest $request)
    {
        $data = $request->all();
        Cliente::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $data = $request->all();
        $cliente->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Cliente::select('clie_id', DB::raw("CONCAT(clie_nombres,' ', clie_paterno,' ',clie_materno, ' | ', clie_nro_documento ) AS cliente"))
                ->orWhere('clie_nombres', 'like', '%' . $searchTerm . '%')
                ->orWhere('clie_paterno', 'like', '%' . $searchTerm . '%')
                ->orWhere('clie_materno', 'like', '%' . $searchTerm . '%')
                ->orWhere('clie_nro_documento', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
