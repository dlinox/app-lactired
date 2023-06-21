<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $primaryKey = 'prov_id';

    protected $fillable = [
        'prov_dni',
        'prov_paterno',
        'prov_materno',
        'prov_nombres',
        'prov_sexo',
        'prov_precio_alta',
        'prov_precio_baja',
        'prov_latitud',
        'prov_longitud',
        'prov_activo',
        'prov_plan_id',
    ];

    protected $casts = [
        'prov_activo' => 'boolean',
        // 'prov_latitud' => 'decimal:11,8',
        // 'prov_longitud' => 'decimal:11,8',
        'prov_precio_alta' => 'decimal:2',
        'prov_precio_baja' => 'decimal:2',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "prov_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "prov_nombres", 'short' => false, 'order' => 'ASC'],
        ['text' => "Paterno", 'value' => "prov_paterno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Materno", 'value' => "prov_materno", 'short' => false, 'order' => 'ASC'],
        ['text' => "DNI", 'value' => "prov_dni", 'short' => false, 'order' => 'ASC'],
        ['text' => "Precio alta", 'value' => "prov_precio_alta", 'short' => false, 'order' => 'ASC'],
        ['text' => "Precio baja", 'value' => "prov_precio_baja", 'short' => false, 'order' => 'ASC'],
    ];


    public function planta()
    {
        return $this->belongsTo(Planta::class, 'prov_plan_id', 'plan_id');
    }
}
