<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tdoc_abreviatura' => strtoupper($this->tdoc_abreviatura),
        ]);
    }


    public function rules(): array
    {
        return [
            'tdoc_nombre' => 'required|unique:tipo_documentos,tdoc_nombre,' . ($this->tipo_documento ? $this->tipo_documento->tdoc_id : 'NULL') . ',tdoc_id',
            'tdoc_abreviatura' => 'required|max:8|unique:tipo_documentos,tdoc_abreviatura,' . ($this->tipo_documento ? $this->tipo_documento->tdoc_id : 'NULL') . ',tdoc_id',
        ];
    }
    public function messages()
    {
        return [
            'tdoc_nombre.required' => 'El nombre es obligatorio.',
            'tdoc_nombre.unique' => 'El nombre de  ya está en uso.',
            'tdoc_abreviatura.required' => 'La abeviatura es obligatorio.',
            'tdoc_abreviatura.unique' => 'La abeviatura ya está en uso.',
            'tdoc_abreviatura.max' => 'La abeviatura no puede exceder los 8 caracteres.',
        ];
    }
}
