<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCertificacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tcer_nombre' => 'required|unique:tipo_certificaciones,tcer_nombre,' . ($this->tipoCertificacione ? $this->tipoCertificacione->tcer_id : 'NULL') . ',tcer_id',
        ];
    }

    public function messages()
    {
        return [
            'tcer_nombre.required' => 'El nombre es obligatorio.',
            'tcer_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
