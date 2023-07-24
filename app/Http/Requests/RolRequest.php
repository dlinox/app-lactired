<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->role ? $this->role->id : null;
        return [

            'name' => 'required|unique:roles,name,' . $roleId,
            'route_redirect' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'El nombre ya esta en uso.',
            'route_redirect.required' => 'Laruta base es obligatorio.',
        ];
    }
}
