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
    public static $headers =  [
        ['text' => "ID", 'value' => "vent_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Serie", 'value' => "vent_serie", 'short' => false, 'order' => 'ASC'],
        ['text' => "Número", 'value' => "vent_numero", 'short' => false, 'order' => 'ASC'],
        ['text' => "Fecha", 'value' => "vent_fecha", 'short' => false, 'order' => 'ASC'],
        ['text' => "Total", 'value' => "vent_total", 'short' => false, 'order' => 'ASC'],
        ['text' => "Tipo", 'value' => "vent_tipo_comprobante", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "vent_estado", 'short' => false, 'order' => 'ASC'],
    ];

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
