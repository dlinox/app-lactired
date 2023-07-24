<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsumoRequest;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InsumoController extends Controller
{

    protected $user;
    protected $planta;
    protected $insumo;
    public function __construct()
    {
        $this->insumo = new Insumo();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->planta = $this->user->hasRole('Super Admin') ? null : $this->user->user_plan_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Insumo::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('insu_nombre', 'like', '%' . $searchTerm . '%');
        }

        if ($this->planta != null) {
            $query->where('insu_plan_id', $this->planta);
        }

        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Almacen/Insumo/index', [
            'items' => $items,
            'headers' => $this->insumo->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(InsumoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $data = $request->all();

                if ($request->insu_id) {
                    $insumo = Insumo::find($request->insu_id);
                    $insumo->update($data);
                    if ($request->hasFile('insu_imagen')) {
                        $this->guardarArchivo($request, $insumo);
                    }
                } else {
                    $insumo = Insumo::create($data);
                    $this->guardarArchivo($request, $insumo);
                }
            
                return redirect()->back()->with('success', 'Elemento creado exitosamente.');
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public function update(InsumoRequest $request, Insumo $insumo)
    {
        $data = $request->all();
        $insumo->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Insumo $insumo)
    {
        $insumo->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {

            $query = Insumo::query();
            $query->where('insu_nombre', 'like', '%' . $request->search . '%');

            if ($this->planta != null) {
                $query->where('insu_plan_id', $this->planta);
            }

            $results = $query->limit(30)->get();
        }

        return response()->json($results);
    }

    public function guardarArchivo($request, Insumo $insumo)
    {
        $this->validate(
            $request,
            [
                'insu_imagen' => 'required|mimes:jpg,jpeg,png|max:4000',
            ],
            [
                'insu_imagen.required' => 'La imagen es obligatoria',
                'insu_imagen.mimes' => 'Solo se permiten imágenes en formato jpeg, jpg y png',
                'insu_imagen.max' => 'Tamaño máximo 4MB',
            ]
        );

        $imagen = $request->file('insu_imagen');

        $nombreImagen = 'image' . '-' .   str_pad($insumo->insu_id, 10, '0', STR_PAD_LEFT)   . '.' . $imagen->extension();

        $ruta = $imagen->storeAs('imagenes/insumos', $nombreImagen, 'public');

        $insumo->insu_imagen =  $ruta;
        $insumo->save();
    }
}
