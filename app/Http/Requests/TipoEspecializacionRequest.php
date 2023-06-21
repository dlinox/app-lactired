<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoEspecializacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tesp_nombre' => 'required|unique:tipo_especializaciones,tesp_nombre,' . ($this->tipo_especializacione ? $this->tipo_especializacione->tesp_id : 'NULL') . ',tesp_id',
        ];
    }

    public function messages()
    {
        return [
            'tesp_nombre.required' => 'El nombre es obligatorio.',
            'tesp_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
