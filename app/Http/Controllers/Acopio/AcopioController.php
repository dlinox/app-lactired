<?php

namespace App\Http\Controllers\Acopio;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcopioRequest;
use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AcopioController extends Controller
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
        if ($request->has('comprobante')) {

            $request->comprobante  = in_array($request->comprobante, ["BOLETA", "FACTURA"]) ?  $request->comprobante : 'BOLETA';

            $defaults = [
                'planta' => $this->planta,
                'fecha' => date('Y-m-d'),
                'comprobante' =>  $request->comprobante,
                'serie' => $request->comprobante == 'BOLETA' ? 'B100'  : 'F100',
                'numero' => $this->getNextNumero($request->comprobante == 'BOLETA' ? 'B100'  : 'F100'),
            ];
        } else {
            $defaults = [
                'planta' => $this->planta,
                'fecha' => date('Y-m-d'),
                'comprobante' => 'BOLETA',
                'serie' => 'B100',
                'numero' => $this->getNextNumero(),
            ];
        }
        return Inertia::render('Acopio/create', [
            'insumo' => Insumo::where('insu_plan_id', $this->planta)->where('insu_nombre', 'like', 'LECHE%')->first(),
            'defaults' => $defaults
        ]);
    }


    public function store(AcopioRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $compra =  Compra::create($request->all());

                $this->guardarArchivo($request, $compra);

                foreach ($request->comp_detalle as $value) {
                    CompraDetalle::create([
                        'cdet_insu_id' =>  $value['insu_id'],
                        'cdet_cantidad' =>  $value['cantidad'],
                        'cdet_precio' =>  $value['precio'],
                        'cdet_importe' =>  $value['cantidad'] * $value['precio'],
                        'cdet_comp_id' =>  $compra->comp_id,
                    ]);

                    $insumo = Insumo::find($value['insu_id']);
                    $newStock = $insumo->insu_stock + $value['cantidad'];
                    $insumo->insu_stock = $newStock;
                    $insumo->save();
                }

                return back()->with('success', 'Compra registrada con exito.');
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    protected function getNextNumero($serie = 'B100', $planta = 1)
    {
        $maxVentNumero = Compra::where('comp_serie', $serie)
            ->where('comp_plan_id', $planta)
            ->max('comp_numero');

        $maxVentNumero = $maxVentNumero ? $maxVentNumero + 1 : 1;

        return str_pad($maxVentNumero, 10, '0', STR_PAD_LEFT);
    }


    public function guardarArchivo($request, Compra $compra)
    {
        $this->validate(
            $request,
            [
                'comp_imagen' => 'required|mimes:jpg,jpeg,png|max:4000',
            ],
            [
                'comp_imagen.required' => 'La imagen es obligatoria',
                'comp_imagen.mimes' => 'Solo se permiten imágenes en formato jpeg, jpg y png',
                'comp_imagen.max' => 'Tamaño máximo 4MB',
            ]
        );

        $imagen = $request->file('comp_imagen');

        $nombreImagen = 'image' . '-' . $compra->comp_plan_id . '-' . $compra->comp_serie . '-' . $compra->comp_numero . '.' . $imagen->extension();

        $ruta = $imagen->storeAs('imagenes', $nombreImagen, 'public');

        $compra->comp_imagen =  $ruta;
        $compra->save();
    }
}
