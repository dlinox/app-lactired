<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaEmpleado extends Model
{
    use HasFactory;

    protected $table = 'planta_empleados';
    protected $primaryKey = 'plem_id';
    public $timestamps = true;

    protected $fillable = [
        'plem_activo',
        'plem_fecha_alta',
        'plem_fecha_baja',
        'plem_responsable',
        'plem_plan_id',
        'plem_empl_id',
    ];

    protected $casts = [
        'plem_activo' => 'boolean',
        'plem_responsable' => 'boolean',
    ];

    public function planta()
    {
        return $this->belongsTo(Planta::class, 'plem_plan_id', 'plan_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'plem_empl_id', 'empl_id');
    }
}
