<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoMaquinariaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tmaq_nombre' => 'required|unique:tipo_maquinarias,tmaq_nombre,' . ($this->tipo_maquinaria ? $this->tipo_maquinaria->tmaq_id : 'NULL') . ',tmaq_id',
        ];
    }

    public function messages()
    {
        return [
            'tmaq_nombre.required' => 'El nombre es obligatorio.',
            'tmaq_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
