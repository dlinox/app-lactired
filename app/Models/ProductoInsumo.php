<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoInsumo extends Model
{
    use HasFactory;

    protected $table = 'producto_insumos';
    protected $primaryKey = 'pinsu_id';
    protected $fillable = [
        'pinsu_insu_id',
        'pinsu_prod_id',
        'pinsu_umed_id',
        'pinsu_cantidad',
        'pinsu_precio',
    ];

    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
