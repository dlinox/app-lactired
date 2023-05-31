<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoEmpresaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'temp_nombre' => 'required|unique:tipo_empresas,temp_nombre,' . ($this->tipo_empresa ? $this->tipo_empresa->temp_id : 'NULL') . ',temp_id',
        ];
    }

    public function messages()
    {
        return [
            'temp_nombre.required' => 'El nombre es obligatorio.',
            'temp_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
