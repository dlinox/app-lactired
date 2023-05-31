<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalidadProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'cpro_nombre' => 'required|unique:calidad_productos,cpro_nombre,' . ($this->calidad_producto ? $this->calidad_producto->cpro_id : 'NULL') . ',cpro_id',
        ];
    }

    public function messages()
    {
        return [
            'cpro_nombre.required' => 'El nombre es obligatorio.',
            'cpro_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
