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

use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;

// use PDF;

class PagoController extends Controller
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


    public function create(Request $request)
    {
        $defaults = [
            'proveedores' =>  Pago::getProveedoresPago($this->planta),
            'fecha' => date('Y-m-d'),
            'numero' => $this->getNextNumero($this->planta),
            'planta' => $this->planta,
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
                foreach ($request->pago_detalle as  $value) {
                    PagoDetalle::create([
                        'pdet_pago_id' =>  $pago->pago_id,
                        'pdet_comp_id' =>  $value['comp_id'],
                    ]);
                    Compra::where('comp_id', $value['comp_id'])->update(['comp_estado_deuda' => 1]);
                }


                $pathPDF = $this->generarPDF($pago, $request->pago_detalle);


                return back()->with(['success' => 'Pago registrado con exito.', 'data' => $pathPDF]);
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

    public function generarPDF($pago, $detalle)
    {


        $fecha = date('d/m/Y H:i:s');
        $pdf = SnappyPdf::loadView('pdf.pagos.ticket', compact('fecha', 'detalle', 'pago'));

        $pdfContent = $pdf->output();

        $fileName = 'pdf/pagos/ticket-' . $pago->pago_numero . '.pdf';

        Storage::disk('public')->put($fileName, $pdfContent);

        $pago->pago_ticket = $fileName;
        $pago->save();

        $url = Storage::disk('public')->url($fileName);

        return $url;
    }
}
