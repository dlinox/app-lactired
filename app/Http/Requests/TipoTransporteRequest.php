<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoTransporteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ttra_nombre' => 'required|unique:tipo_transportes,ttra_nombre,' . ($this->tipo_transporte ? $this->tipo_transporte->ttra_id : 'NULL') . ',ttra_id',
        ];
    }

    public function messages()
    {
        return [
            'ttra_nombre.required' => 'El nombre es obligatorio.',
            'ttra_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
