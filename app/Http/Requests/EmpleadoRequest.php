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
        $emplId = $this->empleado ? $this->empleado->empl_id : null;

        return [
            'empl_nombres' => 'required|string|max:100',
            'empl_materno' => 'nullable|string|max:100',
            'empl_paterno' => 'nullable|string|max:100',
            'empl_dni' => 'required|string|size:8|unique:empleados,empl_dni,' . $emplId . ',empl_id',
            'empl_telefono' => 'required|string|size:9|unique:empleados,empl_telefono,' . $emplId . ',empl_id',
            'empl_email' => 'required|string|email|max:100|unique:empleados,empl_email,' . $emplId . ',empl_id',
            'empl_fecha_nac' => 'nullable|date',
            'empl_sexo' => 'nullable|in:M,F',
            'empl_fecha_inicio_actividad' => 'nullable|date',
            'empl_gins_id' => 'nullable|exists:grado_instrucciones,gins_id',
            'empl_prof_id' => 'nullable|exists:profesiones,prof_id',
            'empl_carg_id' => 'nullable|exists:cargos,carg_id',
        ];
    }
    public function messages()
    {
        return [
            'empl_nombres.required' => 'El campo Nombres es obligatorio.',
            'empl_materno.max' => 'El campo Materno no debe exceder los 100 caracteres.',
            'empl_paterno.max' => 'El campo Paterno no debe exceder los 100 caracteres.',
            'empl_dni.required' => 'El campo DNI es obligatorio.',
            'empl_dni.size' => 'El DNI debe tener 8 caracteres.',
            'empl_dni.unique' => 'El DNI ya está en uso por otro empleado.',
            'empl_telefono.required' => 'El campo Teléfono es obligatorio.',
            'empl_telefono.size' => 'El Teléfono debe tener 9 caracteres.',
            'empl_telefono.unique' => 'El Teléfono ya está en uso por otro empleado.',
            'empl_email.required' => 'El campo Email es obligatorio.',
            'empl_email.email' => 'El formato del Email no es válido.',
            'empl_email.max' => 'El Email no debe exceder los 100 caracteres.',
            'empl_email.unique' => 'El Email ya está en uso por otro empleado.',
            'empl_fecha_nac.date' => 'El campo Fecha de Nacimiento debe ser una fecha válida.',
            'empl_sexo.in' => 'El campo Sexo debe ser "M" o "F".',
            'empl_fecha_inicio_actividad.date' => 'El campo Fecha de Inicio de Actividad debe ser una fecha válida.',
            'empl_gins_id.exists' => 'El Grado de Instrucción seleccionado no existe.',
            'empl_prof_id.exists' => 'La Profesión seleccionada no existe.',
            'empl_carg_id.exists' => 'El Cargo seleccionado no existe.',
            // Agrega más mensajes personalizados para cada regla de validación si es necesario.
        ];
    }
}
