<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $primaryKey = 'comp_id';
    public $timestamps = true;

    protected $fillable = [
        'comp_id',
        'comp_serie',
        'comp_numero',
        'comp_correlativo',
        'comp_fecha',
        'comp_subtotal',
        'comp_total',
        'comp_importe',
        'comp_igv',
        'comp_estado',
        'comp_tipo_pago',
        'comp_tipo',
        'comp_estado_deuda',
        'comp_imagen',
        'comp_plan_id',
        'comp_prov_id',
        'comp_tipo_comprobante',
    ];

    protected $casts = [
        'comp_estado' => 'boolean',
        'comp_tipo_pago' => 'boolean',
        'comp_subtotal' => 'decimal:2',
        'comp_total' => 'decimal:2',
        'comp_igv' => 'decimal:2',
    ];


    public function setVentNumeroAttribute($value)
    {
        $this->attributes['comp_numero'] = str_pad($value, 10, '0', STR_PAD_LEFT);
    }

    public static $headers =  [
        ['text' => "ID", 'value' => "comp_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Serie", 'value' => "comp_serie", 'short' => false, 'order' => 'ASC'],
        ['text' => "Número", 'value' => "comp_numero", 'short' => false, 'order' => 'ASC'],
        ['text' => "Fecha", 'value' => "comp_fecha", 'short' => false, 'order' => 'ASC'],
        ['text' => "Total", 'value' => "comp_total", 'short' => false, 'order' => 'ASC'],
        ['text' => "Tipo", 'value' => "comp_tipo_comprobante", 'short' => false, 'order' => 'ASC'],
        ['text' => "Deuda", 'value' => "comp_estado_deuda", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "comp_estado", 'short' => false, 'order' => 'ASC'],
    ];

    // Relación con el modelo Cliente
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'comp_prov_id', 'prov_id');
    }

    // Relación con el modelo Planta
    public function planta()
    {
        return $this->belongsTo(Planta::class, 'comp_plan_id', 'plan_id');
    }
}
