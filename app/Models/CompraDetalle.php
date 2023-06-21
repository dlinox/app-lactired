<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;

    protected $table = 'compra_detalles';
    protected $primaryKey = 'cdet_id';
    public $timestamps = true;

    protected $fillable = [
        'cdet_cantidad',
        'cdet_precio',
        'cdet_importe',
        'cdet_comp_id',
        'cdet_insu_id'
    ];

    // Relación con el modelo Venta
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'cdet_comp_id', 'comp_id');
    }

    // Relación con el modelo Producto
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'cdet_insu_id', 'insu_id');
    }
}
