<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = "prod_id";

    protected $fillable = [
        'prod_nombre',
        'prod_stock',
        'prod_medida',
        'prod_umed_id',
        'prod_tpro_id',
        'prod_imagen',
        'prod_plan_id',

    ];
    public $headers =  [
        ['text' => "ID", 'value' => "prod_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "prod_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Stock", 'value' => "prod_stock", 'short' => false, 'order' => 'ASC'],
        ['text' => "Medida", 'value' => "prod_medida", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'prod_imagen_url',
        'umed_nombre',
        'tpro_nombre',
        'plant_nombre',
    ];

    public function getProdImagenUrlAttribute()
    {
        return $this->prod_imagen ?   Storage::disk('public')->url($this->prod_imagen) : null;
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'prod_umed_id', 'umed_id');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'prod_tpro_id', 'tpro_id');
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class, 'prod_plan_id', 'plan_id')->select('plan_id', 'plan_razon_social');
    }

    public function getUmedNombreAttribute()
    {
        return $this->unidadMedida->umed_nombre ?? null;
    }

    public function getTproNombreAttribute()
    {
        return $this->tipoProducto->tpro_nombre ?? null;
    }

    public function getPlantNombreAttribute()
    {
        return $this->planta->plan_razon_social ?? null;
    }
}
