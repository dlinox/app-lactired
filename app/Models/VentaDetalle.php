<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $table = 'venta_detalles';
    protected $primaryKey = 'vdet_id';
    public $timestamps = true;

    protected $fillable = [
        'vdet_cantidad',
        'vdet_precio',
        'vdet_importe',
        'vdet_vent_id',
        'vdet_prod_id'
    ];

    // Relación con el modelo Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'vdet_vent_id', 'vent_id');
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'vdet_prod_id', 'prod_id');
    }
}
