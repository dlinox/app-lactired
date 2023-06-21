<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'vent_id';
    public $timestamps = true;

    protected $fillable = [
        'vent_serie',
        'vent_numero',
        'vent_correlativo',
        'vent_fecha',
        'vent_subtotal',
        'vent_total',
        'vent_estado',
        'vent_tipo_pago',
        'vent_clie_id',
        'vent_plan_id',
        'vent_tipo_comprobante'
    ];

    protected $casts = [
        'vent_estado' => 'boolean',
        'vent_tipo_pago' => 'boolean',
        'vent_subtotal' => 'decimal:2',
        'vent_total' => 'decimal:2',
    ];

    // public function getVentNumeroAttribute($value)
    // {
    //     return str_pad($value, 10, '0', STR_PAD_LEFT);
    // }

    public function setVentNumeroAttribute($value)
    {
        $this->attributes['vent_numero'] = str_pad($value, 10, '0', STR_PAD_LEFT);
    }

    // public $headers =  [
    //     ['text' => "ID", 'value' => "prov_id", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "Nombre", 'value' => "prov_nombres", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "Paterno", 'value' => "prov_paterno", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "Materno", 'value' => "prov_materno", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "DNI", 'value' => "prov_dni", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "Precio alta", 'value' => "prov_precio_alta", 'short' => false, 'order' => 'ASC'],
    //     ['text' => "Precio baja", 'value' => "prov_precio_baja", 'short' => false, 'order' => 'ASC'],
    // ];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'vent_clie_id', 'clie_id');
    }

    // Relación con el modelo Planta
    public function planta()
    {
        return $this->belongsTo(Planta::class, 'vent_plan_id', 'plan_id');
    }
}
