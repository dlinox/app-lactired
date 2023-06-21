<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'carg_nombre' => 'required|unique:cargos,carg_nombre,' . ($this->cargo ? $this->cargo->carg_id : 'NULL') . ',carg_id',
        ];
    }

    public function messages()
    {
        return [
            'carg_nombre.required' => 'El nombre es obligatorio.',
            'carg_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
