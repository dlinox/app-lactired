<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inversion extends Model
{
    use HasFactory;
    protected $table = 'inversiones';
    protected $primaryKey = 'inver_id';
    protected $fillable = [
        'inver_plan_id',
        'inver_umed_id',
        'inver_rubro',
        'inver_tipo',
        'inver_cantidad',
        'inver_valor_unitario',
        'inver_periodo',
    ];
    protected $casts = [
        'inver_plan_id' => 'integer',
        'inver_umed_id' => 'integer',
        'inver_cantidad' => 'integer',
        'inver_valor_unitario' => 'decimal:2',
        'inver_total' => 'decimal:2',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "inver_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Rubro", 'value' => "inver_rubro", 'short' => false, 'order' => 'ASC'],
        ['text' => "Tipo", 'value' => "inver_tipo", 'short' => false, 'order' => 'ASC'],
        ['text' => "Cantidad", 'value' => "inver_cantidad", 'short' => false, 'order' => 'ASC'],
        ['text' => "Valor Unitario", 'value' => "inver_valor_unitario", 'short' => false, 'order' => 'ASC'],
        ['text' => "Total", 'value' => "inver_total", 'short' => false, 'order' => 'ASC'],
        ['text' => "Periodo", 'value' => "inver_periodo", 'short' => false, 'order' => 'ASC'],

    ];
}
