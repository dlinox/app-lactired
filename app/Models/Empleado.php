<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = "empl_id";
    protected $fillable = [
        'empl_paterno',
        'empl_materno',
        'empl_nombres',
        'empl_dni',
        'empl_telefono',
        'empl_email',
        'empl_fecha_nac',
        'empl_sexo',
        'empl_fecha_inicio_actividad',
        'empl_posi_id',
        'empl_gins_id',
        'empl_prof_id',
        'empl_rdes_id',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "empl_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "empl_nombres", 'short' => false, 'order' => 'ASC'],
        ['text' => "Paterno", 'value' => "empl_paterno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Materno", 'value' => "empl_materno", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'empl_fecha_nac' => 'date',
        'empl_fecha_inicio_actividad' => 'date',
    ];


    public function posicion()
    {
        return $this->belongsTo(Posicion::class, 'empl_posi_id');
    }

    public function gradoInstruccion()
    {
        return $this->belongsTo(GradoInstruccion::class, 'empl_gins_id');
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class, 'empl_prof_id');
    }

    public function rolDesempeniado()
    {
        return $this->belongsTo(RolDesempeniado::class, 'empl_rdes_id');
    }

}
