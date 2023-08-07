<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductoController extends Controller
{

    protected $user;
    protected $producto;
    public function __construct()
    {
        $this->producto = new Producto();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Producto::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('prod_nombre', 'like', '%' . $searchTerm . '%');
        }
        $query->where('prod_plan_id', $this->user->user_plan_id);

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Almacen/Producto/index', [
            'items' => $items,
            'headers' => $this->producto->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(ProductoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->all();
                $data['prod_plan_id'] = $this->user->user_plan_id;
                if ($request->prod_id) {
                    $producto = Producto::find($request->prod_id);
                    $producto->update($data);
                    if ($request->hasFile('prod_imagen')) {
                        $this->guardarArchivo($request, $producto);
                    }
                } else {
                    $producto = Producto::create($data);
                    $this->guardarArchivo($request, $producto);
                }

                return redirect()->back()->with('success', 'Elemento creado exitosamente.');
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        $data = $request->all();
        $producto->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {

        $results = [];
        if ($request->has('search')) {
            $query = Producto::query();
            $query->where('prod_nombre', 'like', '%' . $request->search . '%');
            $query->where('prod_plan_id', $this->user->user_plan_id);


            $results = $query->limit(30)->get();
        }

        return response()->json($results);
    }

    public function guardarArchivo($request, $producto)
    {
        $this->validate(
            $request,
            [
                'prod_imagen' => 'required|mimes:jpg,jpeg,png|max:4000',
            ],
            [
                'prod_imagen.required' => 'La imagen es obligatoria',
                'prod_imagen.mimes' => 'Solo se permiten imágenes en formato jpeg, jpg y png',
                'prod_imagen.max' => 'Tamaño máximo 4MB',
            ]
        );

        $imagen = $request->file('prod_imagen');

        $nombreImagen = 'image' . '-' .   str_pad($producto->prod_id, 10, '0', STR_PAD_LEFT)   . '.' . $imagen->extension();

        $ruta = $imagen->storeAs('imagenes/productos', $nombreImagen, 'public');

        $producto->prod_imagen =  $ruta;
        $producto->save();
    }
}
