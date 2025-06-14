<?php

namespace App\Http\Controllers\Acopio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagoRequest;
use App\Models\Compra;
use App\Models\Pago;
use App\Models\PagoDetalle;
use App\Models\Planta;
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
            $this->planta =  $this->user->user_plan_id;
            return $next($request);
        });
    }


    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Pago::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('pago_numero', 'like', '%' . $searchTerm . '%');
        }

        if ($this->planta != null) {
            $query->where('pago_plan_id', $this->planta);
        }

        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Acopio/Pago/index', [
            'items' => $items,
            'headers' => Pago::$headers,
            'filters' => [
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
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

            DB::beginTransaction();

            $pago =  Pago::create($request->all());

            foreach ($request->pago_detalle as  $value) {
                PagoDetalle::create([
                    'pdet_pago_id' =>  $pago->pago_id,
                    'pdet_comp_id' =>  $value['comp_id'],
                ]);
                Compra::where('comp_id', $value['comp_id'])->update(['comp_estado_deuda' => 1]);
            }

            $pathPDF = $this->generarPDF($pago, $request->pago_detalle);
            DB::commit();
            return back()->with(['success' => 'Pago registrado con exito.', 'data' => $pathPDF]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public function destroy(Pago $pago)
    {
        $pago->update(['pago_estado' => 0]);
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
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

        $planta = Planta::where('plan_id', $pago->pago_plan_id)->first();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [60, 180], // ancho x alto en milímetros
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
        ]);

        $html = view('pdf.pagos.ticket', compact('fecha', 'detalle', 'pago', 'planta'))->render();
        $mpdf->WriteHTML($html);
        
        $fileName = 'pdf/pagos/ticket-' . $pago->pago_numero . '.pdf';

        Storage::disk('public')->put($fileName, $mpdf->Output('', 'S'));

        $pago->pago_ticket = $fileName;
        $pago->save();

        $url = Storage::disk('public')->url($fileName);

        return $url;
    }
}
