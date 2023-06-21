<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'inst_nombre' => 'required|unique:instituciones,inst_nombre,' . ($this->institucione ? $this->institucione->inst_id : 'NULL') . ',inst_id',
        ];
    }

    public function messages()
    {
        return [
            'inst_nombre.required' => 'El nombre es obligatorio.',
            'inst_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
