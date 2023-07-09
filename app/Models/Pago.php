<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    use HasFactory;

    protected $primaryKey = 'pago_id';
    public $timestamps = true;

    protected $fillable = [
        'pago_numero',
        'pago_monto',
        'pago_fecha',
        'pago_estado',
        'pago_prov_id',
        'pago_plan_id',
    ];

    protected $casts = [
        'pago_fecha' => 'date',
        'pago_estado' => 'boolean',
        'pago_monto' => 'decimal:2',
    ];

    public static function getProveedoresPago($planta)
    {
        $user = Auth::user();

        $proveedores = Proveedor::select(
            'prov_id',
            DB::raw("CONCAT(prov_nombres , ' | ', prov_dni ,  ' - S/.' ,  SUM(comp_total) , ' (' , COUNT(comp_id) ,  ')'  )  as detalle ")
        )
            ->join('compras', 'comp_prov_id', '=', 'prov_id')
            ->where('comp_tipo', 0)
            ->where('comp_estado', 1)
            // ->where('comp_tipo_pago', 1)
            ->where('comp_estado_deuda', 0)
            ->where('comp_plan_id', $planta)
            ->groupBy('prov_id')
            ->get();

        return $proveedores;
    }

    public static function getDetallePagoProveedor($proveedor)
    {
        $user = Auth::user();

        $proveedores = Proveedor::select(
            'prov_id',
            'comp_id',
            'comp_total',
            'comp_serie',
            'comp_serie',
            'comp_numero',
            'comp_fecha'
        )
            ->join('compras', 'comp_prov_id', '=', 'prov_id')
            ->where('comp_tipo', 0)
            ->where('comp_estado', 1)
            ->where('comp_estado_deuda', 0)
            ->where('comp_plan_id', $user->user_plan_id)
            ->where('prov_id', $proveedor)
            ->get();

        return $proveedores;
    }
}
