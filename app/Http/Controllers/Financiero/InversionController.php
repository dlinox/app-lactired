<?php

namespace App\Http\Controllers\Financiero;

use App\Http\Controllers\Controller;
use App\Models\Inversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InversionController extends Controller
{

    protected $user;
    protected $inversion;
    public function __construct()
    {
        $this->inversion = new Inversion();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $query = Inversion::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('inver_rubro', 'like', '%' . $searchTerm . '%');
        }
        $query->where('inver_plan_id', $this->user->user_plan_id);

        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Financiero/Inversion/index', [
            'items' => $items,
            'headers' => $this->inversion->headers,
            'filters' => [
                'search' => $request->search,
            ],
            'perPageOptions' => [12, 24, 48, 96], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['inver_plan_id'] = $this->user->user_plan_id;

            if ($request->inver_id) {
                $item = Inversion::find($request->inver_id);
                $item->update($data);
            } else {
                $item = Inversion::create($data);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Elemento creado exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    // public function update(InsumoRequest $request, Insumo $insumo)
    // {
    //     $data = $request->all();
    //     $insumo->update($data);
    //     return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    // }

    public function destroy(Inversion $inversion)
    {
        $inversion->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
