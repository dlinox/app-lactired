<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NivelCapacitacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'ncap_nombre' => 'required|unique:nivel_capacitaciones,ncap_nombre,' . ($this->nivel_capacitacion ? $this->nivel_capacitacion->ncap_id : 'NULL') . ',ncap_id',
        ];
    }

    public function messages()
    {
        return [
            'ncap_nombre.required' => 'El nombre del nivel de capacitación es obligatorio.',
            'ncap_nombre.unique' => 'El nombre del nivel de capacitación ya existe.',
        ];
    }
}
