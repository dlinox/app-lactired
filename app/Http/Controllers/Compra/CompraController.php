<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompraController extends Controller
{

  protected $user;
  protected $planta;
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      $this->planta = $this->user->user_plan_id;
      return $next($request);
    });
  }

  public function index(Request $request)
  {

    $perPage = $request->input('perPage', 10);
    $query = Compra::query();

    // Búsqueda por nombre de área
    if ($request->has('search')) {
      $searchTerm = $request->search;
      $query->where('comp_numero', 'like', '%' . $searchTerm . '%');
    }

    if ($this->planta != null) {
      $query->where('comp_plan_id', $this->planta);
    }

    $query->where('comp_tipo', 1);
    $items = $query->paginate($perPage)->appends($request->query());

    return Inertia::render('Compra/index', [
      'items' => $items,
      'headers' => Compra::$headers,
      'filters' => [
        'search' => $request->search,
      ],
      'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
    ]);
  }

  public function create(Request $request)
  {

    if ($request->has('comprobante')) {

      $request->comprobante  = in_array($request->comprobante, ["BOLETA", "FACTURA"]) ?  $request->comprobante : 'BOLETA';

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' =>  $request->comprobante,
        'serie' => $request->comprobante == 'BOLETA' ? 'B100'  : 'F100',
        'numero' => $this->getNextNumero($request->comprobante == 'BOLETA' ? 'B100'  : 'F100',  $this->planta),
        'planta' => $this->planta,
      ];
    } else {

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' => 'BOLETA',
        'serie' => 'B100',
        'numero' => $this->getNextNumero('B100', $this->planta),
        'planta' => $this->planta,
      ];
    }
    return Inertia::render('Compra/create', ['defaults' => $defaults, 'insumos' => Insumo::where('insu_plan_id', $this->planta)->get()]);
  }

  public function destroy(Compra $compra)
  {
    $compra->update(['comp_estado' => 0]);
    return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
  }


  protected function getNextNumero($serie, $planta)
  {
    $maxVentNumero = Compra::where('comp_serie', $serie)
      ->where('comp_plan_id', $planta)
      ->max('comp_numero');

    $maxVentNumero = $maxVentNumero ? $maxVentNumero + 1 : 1;

    return str_pad($maxVentNumero, 10, '0', STR_PAD_LEFT);
  }

  public function store(CompraRequest $request)
  {
    try {
      DB::transaction(function () use ($request) {
        $compra =  Compra::create($request->all());
        foreach ($request->comp_detalle as $key => $value) {
          CompraDetalle::create([
            'cdet_cantidad' =>  $value['cantidad'],
            'cdet_precio' =>  $value['precio'],
            'cdet_importe' =>  $value['importe'],
            'cdet_comp_id' =>  $compra->comp_id,
            'cdet_insu_id' =>  $value['insu_id'],
          ]);
        }
        // return to_route('ventas.create')->with('success', 'Venta registrada con exito.');
        return back()->with('success', 'Compra registrada con exito.');
      });
    } catch (\Throwable $th) {
      return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
    }
  }
}
