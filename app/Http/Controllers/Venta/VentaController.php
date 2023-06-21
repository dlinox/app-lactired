<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Http\Requests\VentaRequest;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VentaController extends Controller
{

  public function create(Request $request)
  {

    if ($request->has('comprobante')) {

      $request->comprobante  = in_array($request->comprobante, ["BOLETA", "FACTURA"]) ?  $request->comprobante : 'BOLETA';

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' =>  $request->comprobante,
        'serie' => $request->comprobante == 'BOLETA' ? 'B000'  : 'F000',
        'numero' => $this->getNextNumero($request->comprobante == 'BOLETA' ? 'B000'  : 'F000'),
      ];
    } else {

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' => 'BOLETA',
        'serie' => 'B000',
        'numero' => $this->getNextNumero(),
      ];
    }

    return Inertia::render('Venta/create', [
      'defaults' => $defaults
    ]);
  }

  protected function getNextNumero($serie = 'B000', $planta = 1)
  {
    $maxVentNumero = Venta::where('vent_serie', $serie)
      ->where('vent_plan_id', $planta)
      ->max('vent_numero');

    $maxVentNumero = $maxVentNumero ? $maxVentNumero + 1 : 1;

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
        // return to_route('ventas.create')->with('success', 'Venta registrada con exito.');
        return back()->with(['success', 'Venta registrada con exito.',]);
      });
    } catch (\Throwable $th) {
      return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
    }
  }
}
