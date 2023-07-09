<?php

namespace App\Http\Controllers\Acopio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagoRequest;
use App\Models\Compra;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PagoController extends Controller
{
    public function create(Request $request)
    {

        $user = Auth::user();

        $defaults = [
            'proveedores' =>  Pago::getProveedoresPago($user->user_plan_id),
            'fecha' => date('Y-m-d'),
            'numero' => $this->getNextNumero($user->user_plan_id),
            'planta' => $user->user_plan_id,
        ];

        return Inertia::render('Acopio/Pago/create', [
            'defaults' => $defaults
        ]);
    }

    public function store(PagoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $pago =  Pago::create($request->all());

                foreach ($request->pago_detalle as $key => $value) {
                    PagoDetalle::create([
                        'pdet_pago_id' =>  $pago->pago_id,
                        'pdet_comp_id' =>  $value['comp_id'],
                    ]);

                    Compra::where('comp_id', $value['comp_id'])->update(['comp_estado_deuda' => 1]);
                }

                return back()->with('success', 'Pago registrado con exito.');
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public  function getDetallePagoProveedor($id)
    {

        $pagoDetalle = Pago::getDetallePagoProveedor($id);
        return response()->json($pagoDetalle);
    }

    protected function getNextNumero($planta)
    {
        $maxVentNumero = Pago::where('pago_plan_id', $planta)->max('pago_numero');
        $maxVentNumero = $maxVentNumero ? $maxVentNumero + 1 : 1;
        return str_pad($maxVentNumero, 10, '0', STR_PAD_LEFT);
    }
}
