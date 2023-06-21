<?php

namespace App\Http\Controllers\Configuracion\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoComprobanteRequest;
use App\Models\TipoComprobante;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoComprobanteController extends Controller
{
    protected $tipoComprobante;
    public function __construct()
    {
        $this->tipoComprobante = new TipoComprobante();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = TipoComprobante::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('tcom_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Configuracion/Empresa/TipoComprobante/index', [
            'items' => $items,
            'headers' => $this->tipoComprobante->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(TipoComprobanteRequest $request)
    {
        $data = $request->all();
        TipoComprobante::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(TipoComprobanteRequest $request, TipoComprobante $tipoComprobante)
    {
        $data = $request->all();
        $tipoComprobante->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(TipoComprobante $tipoComprobante)
    {
        $tipoComprobante->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

}
