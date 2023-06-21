<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorPrecio extends Model
{
    use HasFactory;
    protected $table = 'proveedor_precios';
    protected $primaryKey = 'ppre_id';
    public $timestamps = true;

    protected $fillable = [
        'ppre_precio',
        'ppre_estado',
        'ppre_prov_id',
    ];

    protected $casts = [
        'ppre_precio' => 'decimal:2',
        'ppre_estado' => 'boolean',
        'ppre_prov_id' => 'integer',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ppre_prov_id', 'prov_id');
    }
}
