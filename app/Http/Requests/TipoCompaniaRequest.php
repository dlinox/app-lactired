<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCompaniaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tcomp_nombre' => 'required|unique:tipo_companias,tcomp_nombre,' . ($this->tipo_compania ? $this->tipo_compania->tcomp_id : 'NULL') . ',tcomp_id',
        ];
    }

    public function messages()
    {
        return [
            'tcomp_nombre.required' => 'El nombre es obligatorio.',
            'tcomp_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
