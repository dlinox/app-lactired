<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MercadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'merc_nombre' => 'required|unique:mercados,merc_nombre,' . ($this->mercado ? $this->mercado->merc_id : 'NULL') . ',merc_id',
        ];
    }

    public function messages()
    {
        return [
            'merc_nombre.required' => 'El nombre es obligatorio.',
            'merc_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
