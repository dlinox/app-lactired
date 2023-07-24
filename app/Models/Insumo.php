<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Insumo extends Model
{
    use HasFactory;

    protected $primaryKey = 'insu_id';
    protected $fillable = [
        'insu_nombre',
        'insu_imagen',
        'insu_stock',
        'insu_medida',
        'insu_umed_id',
        'insu_plan_id',
    ];

    protected $casts = [
        'insu_stock' => 'integer',
        'insu_medida' => 'float',
    ];


    protected $appends = [
        'umed_nombre',
        'plant_nombre',
        'insu_imagen_url'
    ];

    public function getInsuImagenUrlAttribute()
    {
        return $this->insu_imagen ?  Storage::disk('public')->url($this->insu_imagen) : null;
    }

    public $headers =  [
        ['text' => "ID", 'value' => "insu_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "insu_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Stok", 'value' => "insu_stock", 'short' => false, 'order' => 'ASC'],
        ['text' => "Medida", 'value' => "insu_medida", 'short' => false, 'order' => 'ASC'],
    ];

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'insu_umed_id');
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class, 'insu_plan_id');
    }


    public function getUmedNombreAttribute()
    {
        return $this->unidadMedida->umed_nombre ?? null;
    }


    public function getPlantNombreAttribute()
    {
        return $this->planta->plan_razon_social ?? null;
    }
}
