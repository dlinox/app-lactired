<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoComprobanteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'tcom_nombre' => 'required|unique:tipo_comprobantes,tcom_nombre,' . ($this->tipoComprobante ? $this->tipoComprobante->tcom_id : 'NULL') . ',tcom_id',
        ];
    }

    public function messages()
    {
        return [
            'tcom_nombre.required' => 'El nombre es obligatorio.',
            'tcom_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
