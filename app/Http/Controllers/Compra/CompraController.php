<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompraController extends Controller
{

  public function create(Request $request)
  {


    if ($request->has('comprobante')) {

      $request->comprobante  = in_array($request->comprobante, ["BOLETA", "FACTURA"]) ?  $request->comprobante : 'BOLETA';

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' =>  $request->comprobante,
        'serie' => $request->comprobante == 'BOLETA' ? 'B100'  : 'F100',
        'numero' => $this->getNextNumero($request->comprobante == 'BOLETA' ? 'B100'  : 'F100'),
      ];
    } else {

      $defaults = [
        'fecha' => date('Y-m-d'),
        'comprobante' => 'BOLETA',
        'serie' => 'B100',
        'numero' => $this->getNextNumero(),
      ];
    }


    return Inertia::render('Compra/create', ['defaults' => $defaults]);
  }

  protected function getNextNumero($serie = 'B100', $planta = 1)
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
