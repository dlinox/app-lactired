<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tpro_nombre' => 'required|unique:tipo_productos,tpro_nombre,' . ($this->tipo_producto ? $this->tipo_producto->tpro_id : 'NULL') . ',tpro_id',
        ];
    }

    public function messages()
    {
        return [
            'tpro_nombre.required' => 'El nombre es obligatorio.',
            'tpro_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
