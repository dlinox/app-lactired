<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    use HasFactory;
    //protected $table = 'plantas';
    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'plan_razon_social',
        'plan_ruc',
        'plan_marca',
        'plan_tipo_planta',
        'plan_registro_sanitario',
        'plan_marca_registrada',
        'plan_barrio_comunidad',
        'plan_sector',
        'plan_latitud',
        'plan_longitud',
        'plan_tecnificacion',
        'plan_parametros_digesa',
        'plan_parametros_produccion',
        'plan_capacitacion_tdd',
        'plan_tcomp_id',
        'plan_ubig_id',
        'plan_ncap_id',
        'plan_cpro_id',
        'plan_inst_id',
    ];


    protected $casts = [
        'plan_registro_sanitario' => 'boolean',
        'plan_marca_registrada' => 'boolean',
        'plan_tecnificacion' => 'boolean',
        'plan_parametros_digesa' => 'boolean',
        'plan_parametros_produccion' => 'boolean',
        'plan_capacitacion_tdd' => 'boolean',
    ];


    protected $appends = [
        'tipo_compania_nombre',
        'ubigeo_nombre',
        'nivel_capacitacion_nombre',
        'calidad_producto_nombre',
        'institucion_nombre',
    ];

    //protected $with = ['tipoCompania'];

    public $headers =  [
        ['text' => "ID", 'value' => "plan_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "plan_razon_social", 'short' => false, 'order' => 'ASC'],
        ['text' => "RUC", 'value' => "plan_ruc", 'short' => false, 'order' => 'ASC'],
    ];


    public function tipoCompania()
    {
        return $this->belongsTo(TipoCompania::class, 'plan_tcomp_id', 'tcomp_id');
    }

    public function ubigeo()
    {
        return $this->belongsTo(Ubigeo::class, 'plan_ubig_id', 'ubig_id');
    }

    public function nivelCapacitacion()
    {
        return $this->belongsTo(NivelCapacitacion::class, 'plan_ncap_id', 'ncap_id');
    }

    public function calidadProducto()
    {
        return $this->belongsTo(CalidadProducto::class, 'plan_cpro_id', 'cpro_id');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'plan_inst_id', 'inst_id');
    }

    public function getTipoPlantaAttribute($value)
    {
        switch ($value) {
            case 'A':
                return 'Tipo A';
            case 'B':
                return 'Tipo B';
            case 'C':
                return 'Tipo C';
            default:
                return 'Desconocido';
        }
    }

    // Atributo adicional para obtener el nombre de la compañía
    public function getTipoCompaniaNombreAttribute()
    {
        return $this->tipoCompania->tcomp_nombre ??  null;
    }

    // Atributo adicional para obtener el nombre del ubigeo
    public function getUbigeoNombreAttribute()
    {
        return $this->ubigeo->ubig_nombre ??  null;
    }

    // Atributo adicional para obtener el nombre del nivel de capacitación
    public function getNivelCapacitacionNombreAttribute()
    {
        return $this->nivelCapacitacion->ncap_nombre ??  null;
    }

    // Atributo adicional para obtener el nombre de la calidad del producto
    public function getCalidadProductoNombreAttribute()
    {
        return $this->calidadProducto->cpro_nombre ??  null;
    }

    // Atributo adicional para obtener el nombre de la institución
    public function getInstitucionNombreAttribute()
    {
        return $this->institucion->inst_nombre ??  null;
    }
}
