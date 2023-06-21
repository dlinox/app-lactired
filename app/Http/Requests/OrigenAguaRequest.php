<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrigenAguaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'oagu_nombre' => 'required|unique:origen_aguas,oagu_nombre,' . ($this->origenAgua ? $this->origenAgua->oagu_id : 'NULL') . ',oagu_id',
        ];
    }

    public function messages()
    {
        return [
            'oagu_nombre.required' => 'El nombre es obligatorio.',
            'oagu_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
