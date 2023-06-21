<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoMovilidadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tmov_nombre' => 'required|unique:tipo_movilidades,tmov_nombre,' . ($this->tipo_movilidade ? $this->tipo_movilidade->ttra_id : 'NULL') . ',tmov_id',
        ];
    }

    public function messages()
    {
        return [
            'tmov_nombre.required' => 'El nombre es obligatorio.',
            'tmov_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
