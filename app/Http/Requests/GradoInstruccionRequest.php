<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradoInstruccionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $Id = $this->grado_instruccione ? $this->grado_instruccione->gins_id : null;

        return [
            'gins_nombre' => 'required|unique:grado_instrucciones,gins_nombre,' . $Id . ',gins_id',
        ];
    }

    public function messages()
    {
        return [
            'gins_nombre.required' => 'El nombre es obligatorio.',
            'gins_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
