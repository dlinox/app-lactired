<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        'empl_carg_id',
        'empl_gins_id',
        'empl_prof_id',
    ];

    public static $headers =  [
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


    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'empl_carg_id', 'carg_id');
    }

    public function gradoInstruccion()
    {
        return $this->belongsTo(GradoInstruccion::class, 'empl_gins_id', 'gins_id');
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class, 'empl_prof_id', 'prof_id');
    }


    public static function getRoles(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = self::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $items = $query
            ->select(
                'empl_id',
                'empl_paterno',
                'empl_materno',
                'empl_nombres',
                'empl_dni',
                'empl_telefono',
                'empl_email',
                'empl_fecha_nac',
                'empl_sexo',
                'empl_carg_id',
                'empl_gins_id',
                'empl_prof_id',
            )
            ->with('profesion:prof_id,prof_nombre')
            ->with('cargo:carg_id,carg_nombre')
            ->paginate($perPage)->appends($request->query());

        return [
            'items' => $items,
            'headers' => self::$headers,
            'filters' => [
                'search' => $request->search,
            ],
        ];
    }
}
