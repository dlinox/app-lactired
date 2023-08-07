<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $Id = $this->profesione ? $this->profesione->prof_id : null;

        return [
            'prof_nombre' => 'required|unique:profesiones,prof_nombre,' . $Id . ',prof_id',
        ];
    }

    public function messages()
    {
        return [
            'prof_nombre.required' => 'El nombre es obligatorio.',
            'prof_nombre.unique' => 'El nombre ya existe.',
        ];
    }
}
