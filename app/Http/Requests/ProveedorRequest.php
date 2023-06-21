<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $proveedorId = $this->proveedore ? $this->proveedore->prov_id : null;

        return [
            'prov_dni' => 'required|digits:8|unique:proveedores,prov_dni,' . $proveedorId . ',prov_id',
            'prov_paterno' => 'required|max:100',
            'prov_materno' => 'required|max:80',
            'prov_nombres' => 'required|max:80',
            'prov_sexo' => 'required|in:M,F',
            'prov_precio_alta' => 'required|numeric',
            'prov_precio_baja' => 'required|numeric',
            'prov_latitud' => 'nullable|numeric',
            'prov_longitud' => 'nullable|numeric',
            'prov_activo' => 'boolean',
            'prov_plan_id' => 'required|exists:plantas,plan_id',
        ];
    }

    public function messages()
    {
        return [
            'prov_dni.required' => 'El DNI es obligatorio.',
            'prov_dni.digits' => 'El DNI debe tener 8 dígitos numericos.',
            'prov_dni.unique' => 'El DNI ya está siendo utilizado por otro proveedor.',
            'prov_paterno.required' => 'El apellido paterno es obligatorio.',
            'prov_paterno.max' => 'El apellido paterno no puede tener más de :max caracteres.',
            'prov_materno.required' => 'El apellido materno es obligatorio.',
            'prov_materno.max' => 'El apellido materno no puede tener más de :max caracteres.',
            'prov_nombres.required' => 'Los nombres son obligatorios.',
            'prov_nombres.max' => 'Los nombres no pueden tener más de :max caracteres.',
            'prov_sexo.required' => 'El sexo es obligatorio.',
            'prov_sexo.in' => 'El sexo debe ser M (masculino) o F (femenino).',
            'prov_precio_alta.required' => 'El precio de alta es obligatorio.',
            'prov_precio_alta.numeric' => 'El precio de alta debe ser numérico.',
            'prov_precio_baja.required' => 'El precio de baja es obligatorio.',
            'prov_precio_baja.numeric' => 'El precio de baja debe ser numérico.',
            'prov_latitud.numeric' => 'La latitud debe ser numérica.',
            'prov_longitud.numeric' => 'La longitud debe ser numérica.',
            'prov_activo.boolean' => 'El campo activo debe ser verdadero o falso.',
            'prov_plan_id.required' => 'El ID del plan es obligatorio.',
            'prov_plan_id.exists' => 'El ID del plan no existe en la tabla de plantas.',
        ];
    }
}
