<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyeccion extends Model
{
    use HasFactory;
    protected $table = 'proyecciones';
    protected $primaryKey = 'proy_id';
    protected $fillable = [
        'proy_plan_id',
        'proy_anio',
    ];
    public $timestamps = true;
    protected $casts = [
        'proy_plan_id' => 'integer',
        'proy_anio' => 'string',
    ];
}
