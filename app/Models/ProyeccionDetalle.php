<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyeccionDetalle extends Model
{
    use HasFactory;


    protected $table = 'proyeccion_detalles';
    protected $primaryKey = 'proyd_id';
    protected $fillable = [
        'proyd_proy_id',
        'proyd_prod_id',
        'proyd_cantidad_mensual',
    ];
}
