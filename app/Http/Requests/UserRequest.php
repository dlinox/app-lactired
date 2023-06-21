<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes definir la lógica de autorización si es necesario
        return true;
    }

    public function rules()
    {
        $userId = $this->usuario ? $this->usuario->id : null;

        return [
            'name' => 'required',
            'paterno' => 'required|max:40',
            'materno' => 'required|max:40',
            'dni' => 'required|unique:users,dni,' . $userId . '|size:8',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $userId ? 'nullable|min:8' : 'required|min:8',
            'profile_photo' => 'nullable|image|max:2048',
            'user_plan_id' => 'required|exists:plantas,plan_id',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'paterno.required' => 'El apellido paterno es requerido.',
            'paterno.max' => 'El apellido paterno no debe superar los 30 caracteres.',
            'materno.required' => 'El apellido materno es requerido.',
            'materno.max' => 'El apellido materno no debe superar los 30 caracteres.',
            'dni.required' => 'El DNI es requerido.',
            'dni.unique' => 'Ya existe un usuario con ese DNI.',
            'dni.size' => 'El DNI debe tener 8 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Ya existe un usuario con ese correo electrónico.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'profile_photo.image' => 'El archivo debe ser una imagen.',
            'profile_photo.max' => 'El tamaño máximo de la imagen es de 2 MB.',
            'user_plan_id.required' => 'La planta es requerida.',
            'user_plan_id.exists' => 'La planta seleccionada no es válida.',
        ];
    }
}
