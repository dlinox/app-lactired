<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Http\Requests\VentaRequest;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VentaController extends Controller
{

  protected $user;
  protected $planta;
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      $this->planta = $this->user->hasRole('Super Admin') ? null : $this->user->user_plan_id;
      return $next($request);
    });
  }


  public function index(Request $request)
  {

    $perPage = $request->input('perPage', 10);
    $query = Venta::query();

    // Búsqueda por nombre de área
    if ($request->has('search')) {
      $searchTerm = $request->search;
      $query->where('vent_numero', 'like', '%' . $searchTerm . '%');
    }

    if ($this->planta != null) {
      $query->where('vent_plan_id', $this->planta);
    }

    $items = $query->paginate($perPage)->appends($request->query());

    return Inertia::render('Venta/index', [
      'items' => $items,
      'headers' => Venta::$headers,
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
        'serie' => $request->comprobante === 'BOLETA' ? 'B000'  : 'F000',
        'numero' => $this->getNextNumero($request->comprobante === 'BOLETA' ? 'B000'  : 'F000', $this->planta),
        'planta' => $this->planta,
      ];
    } else {

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' => 'BOLETA',
        'serie' => 'B000',
        'numero' => $this->getNextNumero('B000', $this->planta),
        'planta' => $this->planta,
      ];
    }

    return Inertia::render('Venta/create', [
      'defaults' => $defaults
    ]);
  }


  public function destroy(Venta $venta)
  {
    $venta->update(['vent_estado' => 0]);
    return redirect()->back()->with('success', 'Elemento anulado exitosamente.');
  }


  protected function getNextNumero($serie, $planta)
  {
    $maxVentNumero = Venta::where('vent_serie', $serie)
      ->where('vent_plan_id', $planta)
      ->max('vent_numero');

    $maxVentNumero = $maxVentNumero ? (intval($maxVentNumero) + 1) : 1;

    return str_pad($maxVentNumero, 10, '0', STR_PAD_LEFT);
  }

  public function store(VentaRequest $request)
  {
    try {
      DB::transaction(function () use ($request) {
        $venta =  Venta::create($request->all());
        foreach ($request->vent_detalle as $key => $value) {
          VentaDetalle::create([
            'vdet_cantidad' =>  $value['cantidad'],
            'vdet_precio' =>  $value['precio'],
            'vdet_importe' =>  $value['importe'],
            'vdet_vent_id' =>  $venta->vent_id,
            'vdet_prod_id' =>  $value['prod_id'],
          ]);
        }

        return back()->with(['success', 'Venta registrada con exito.']);
      });
    } catch (\Throwable $th) {
      return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
    }
  }
}
