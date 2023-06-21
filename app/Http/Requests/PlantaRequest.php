<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {

        $planId = $this->planta ? $this->planta->plan_id : null;

        return [
            'plan_razon_social' => 'required|string',
            'plan_ruc' => 'required|digits:11|unique:plantas,plan_ruc,' . $planId . ',plan_id',
            'plan_marca' => 'nullable|string|max:100',
            'plan_tipo_planta' => 'required|in:A,B,C',
            'plan_registro_sanitario' => 'required|boolean',
            'plan_marca_registrada' => 'required|boolean',
            'plan_barrio_comunidad' => 'nullable|string|max:100',
            'plan_sector' => 'nullable|string|max:100',
            'plan_latitud' => 'nullable|max:30',
            'plan_longitud' => 'nullable|max:30',
            'plan_tecnificacion' => 'required|boolean',
            'plan_parametros_digesa' => 'required|boolean',
            'plan_parametros_produccion' => 'required|boolean',
            'plan_capacitacion_tdd' => 'required|boolean',
            'plan_tcomp_id' => 'required|exists:tipo_companias,tcomp_id',
            'plan_ubig_id' => 'required|exists:ubigeos,ubig_id',
            'plan_ncap_id' => 'required|exists:nivel_capacitaciones,ncap_id',
            'plan_cpro_id' => 'required|exists:calidad_productos,cpro_id',
            'plan_inst_id' => 'required|exists:instituciones,inst_id',
        ];
    }

    public function messages()
    {
        return [
            'plan_razon_social.required' => 'El campo razón social es obligatorio.',
            'plan_razon_social.string' => 'El campo razón social debe ser una cadena de texto.',
            'plan_ruc.required' => 'El campo RUC es obligatorio.',
            'plan_ruc.digits' => 'El campo RUC debe tener 11 dígitos.',
            'plan_ruc.unique' => 'El RUC ingresado ya está registrado.',
            'plan_marca.string' => 'El campo marca debe ser una cadena de texto.',
            'plan_marca.max' => 'El campo marca no debe exceder los 100 caracteres.',
            'plan_tipo_planta.required' => 'El campo tipo de planta es obligatorio.',
            'plan_tipo_planta.in' => 'El campo tipo de planta debe ser uno de los valores permitidos: A, B, C.',
            'plan_registro_sanitario.required' => 'El campo registro sanitario es obligatorio.',
            'plan_registro_sanitario.boolean' => 'El campo registro sanitario debe ser un valor booleano.',
            'plan_marca_registrada.required' => 'El campo marca registrada es obligatorio.',
            'plan_marca_registrada.boolean' => 'El campo marca registrada debe ser un valor booleano.',
            'plan_barrio_comunidad.string' => 'El campo barrio o comunidad debe ser una cadena de texto.',
            'plan_barrio_comunidad.max' => 'El campo barrio o comunidad no debe exceder los 100 caracteres.',
            'plan_sector.string' => 'El campo sector debe ser una cadena de texto.',
            'plan_sector.max' => 'El campo sector no debe exceder los 100 caracteres.',
            'plan_latitud.max' => 'El campo latitud no debe exceder los 30 caracteres.',
            'plan_longitud.max' => 'El campo longitud no debe exceder los 30 caracteres.',
            'plan_tecnificacion.required' => 'El campo tecnificación es obligatorio.',
            'plan_tecnificacion.boolean' => 'El campo tecnificación debe ser un valor booleano.',
            'plan_parametros_digesa.required' => 'El campo parámetros Digesa es obligatorio.',
            'plan_parametros_digesa.boolean' => 'El campo parámetros Digesa debe ser un valor booleano.',
            'plan_parametros_produccion.required' => 'El campo parámetros producción es obligatorio.',
            'plan_parametros_produccion.boolean' => 'El campo parámetros producción debe ser un valor booleano.',
            'plan_capacitacion_tdd.required' => 'El campo capacitación TDD es obligatorio.',
            'plan_capacitacion_tdd.boolean' => 'El campo capacitación TDD debe ser un valor booleano.',
            'plan_tcomp_id.required' => 'El campo tipo de compañía es obligatorio.',
            'plan_tcomp_id.exists' => 'El tipo de compañía seleccionado no existe.',
            'plan_ubig_id.required' => 'El campo ubigeo es obligatorio.',
            'plan_ubig_id.exists' => 'El ubigeo seleccionado no existe.',
            'plan_ncap_id.required' => 'El campo nivel de capacitación es obligatorio.',
            'plan_ncap_id.exists' => 'El nivel de capacitación seleccionado no existe.',
            'plan_cpro_id.required' => 'El campo calidad de productos es obligatorio.',
            'plan_cpro_id.exists' => 'La calidad de productos seleccionada no existe.',
            'plan_inst_id.required' => 'El campo institución es obligatorio.',
            'plan_inst_id.exists' => 'La institución seleccionada no existe.',
        ];
    }
}
