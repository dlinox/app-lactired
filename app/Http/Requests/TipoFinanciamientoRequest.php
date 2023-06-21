<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoFinanciamientoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tfin_nombre' => 'required|unique:tipo_financiamientos,tfin_nombre,' . ($this->tipo_financiamiento ? $this->tipo_financiamiento->tfin_id : 'NULL') . ',tfin_id',
        ];
    }

    public function messages()
    {
        return [
            'tfin_nombre.required' => 'El nombre es obligatorio.',
            'tfin_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
