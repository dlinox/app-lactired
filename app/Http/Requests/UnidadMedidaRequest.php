<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadMedidaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'umed_simbolo' => strtoupper($this->umed_simbolo),
        ]);
    }


    public function rules(): array
    {
        return [
            'umed_nombre' => 'required|unique:unidad_medidas,umed_nombre,' . ($this->unidades_medida ? $this->unidades_medida->umed_id : 'NULL') . ',umed_id',
            'umed_simbolo' => 'required|max:10|unique:unidad_medidas,umed_simbolo,' . ($this->unidades_medida ? $this->unidades_medida->umed_id : 'NULL') . ',umed_id',
        ];
    }
    public function messages()
    {
        return [
            'umed_nombre.required' => 'El nombre es obligatorio.',
            'umed_nombre.unique' => 'El nombre de  ya está en uso.',
            'umed_simbolo.required' => 'El símbolo es obligatorio.',
            'umed_simbolo.unique' => 'El símbolo ya está en uso.',
            'umed_simbolo.max' => 'El símbolo no puede exceder los 10 caracteres.',
        ];
    }
}
