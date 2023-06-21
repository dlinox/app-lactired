<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'empl_paterno' => 'required|string|max:100',
            'empl_materno' => 'required|string|max:100',
            'empl_nombres' => 'required|string|max:100',
            'empl_dni' => 'required|digits:8',
            'empl_telefono' => 'required|digits:9',
            'empl_email' => 'required|email|max:100',
            'empl_fecha_nac' => 'required|date',
            'empl_sexo' => 'required|in:M,F',
            'empl_fecha_inicio_actividad' => 'required|date',
            'empl_posi_id' => 'required|exists:posiciones,posi_id',
            'empl_gins_id' => 'required|exists:grado_instrucciones,gins_id',
            'empl_prof_id' => 'required|exists:profesiones,prof_id',
            'empl_rdes_id' => 'required|exists:roles_desempeniados,rdes_id',
        ];
    }
    public function messages()
    {
        return [
            'empl_paterno.required' => 'El apellido paterno es obligatorio.',
            'empl_materno.required' => 'El apellido materno es obligatorio.',
            'empl_nombres.required' => 'Los nombres son obligatorios.',
            'empl_dni.required' => 'El DNI es obligatorio.',
            'empl_dni.digits' => 'El DNI debe tener :digits dígitos.',
            'empl_telefono.required' => 'El teléfono es obligatorio.',
            'empl_telefono.digits' => 'El teléfono debe tener :digits dígitos.',
            'empl_email.required' => 'El correo electrónico es obligatorio.',
            'empl_email.email' => 'El correo electrónico debe ser válido.',
            'empl_fecha_nac.required' => 'La fecha de nacimiento es obligatoria.',
            'empl_sexo.required' => 'El sexo es obligatorio.',
            'empl_fecha_inicio_actividad.required' => 'La fecha de inicio de actividad es obligatoria.',
            'empl_posi_id.required' => 'La posición es obligatoria.',
            'empl_gins_id.required' => 'El grado de instrucción es obligatorio.',
            'empl_prof_id.required' => 'La profesión es obligatoria.',
            'empl_rdes_id.required' => 'El rol desempeñado es obligatorio.',
        ];
    }
}
