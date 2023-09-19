<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->clie_tipo_documento == 'DNI' || $this->clie_tipo_documento == 'CE') {
            $this->merge([
                'clie_tipo_persona' => '0', // Persona Natural
            ]);
        } else {
            $this->merge([
                'clie_tipo_persona' => '1', // Persona Jurídica
            ]);
        }
    }


    public function rules()
    {
        $clienteId = $this->cliente ?  $this->cliente->clie_id : null; // Obtener el ID del cliente desde la ruta

        return [
            'clie_nombres' => 'required|string|max:200',
            'clie_paterno' => 'nullable|string|max:50',
            'clie_materno' => 'nullable|string|max:50',
            'clie_tipo_documento' => 'required|in:RUC,DNI,CE',
            'clie_nro_documento' => 'required|digits:8|unique:clientes,clie_nro_documento,' . $clienteId . ',clie_id',
            'clie_tipo_persona' => 'required|in:0,1',
            'clie_direccion' => 'required|string|max:100',
            'clie_telefono' => 'required|numeric|digits:9|unique:clientes,clie_telefono,' . $clienteId . ',clie_id',
            'clie_correo' => 'required|string|email|max:100|unique:clientes,clie_correo,' . $clienteId . ',clie_id',
            'clie_password' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'clie_nombres.required' => 'El campo Nombre es obligatorio.',
            'clie_nombres.max' => 'El campo Nombre no debe exceder los 200 caracteres.',
            'clie_paterno.max' => 'El campo Apellido Paterno no debe exceder los 50 caracteres.',
            'clie_materno.max' => 'El campo Apellido Materno no debe exceder los 50 caracteres.',
            'clie_tipo_documento.required' => 'El campo Tipo de Documento es obligatorio.',
            'clie_tipo_documento.in' => 'El campo Tipo de Documento no es válido.',
            'clie_nro_documento.required' => 'El campo Número de Documento es obligatorio.',
            'clie_nro_documento.digits' => 'El campo Número de Documento debe ser de 8 caracteres.',
            'clie_nro_documento.unique' => 'El Número de Documento ya está registrado.',
            'clie_tipo_persona.required' => 'El campo Tipo de Persona es obligatorio.',
            'clie_tipo_persona.in' => 'El campo Tipo de Persona no es válido.',
            'clie_direccion.required' => 'El campo Dirección es obligatorio.',
            'clie_direccion.max' => 'El campo Dirección no debe exceder los 100 caracteres.',
            'clie_telefono.required' => 'El campo Teléfono es obligatorio.',
            'clie_telefono.numeric' => 'El teléfono debe ser un número.',
            'clie_telefono.digits' => 'El teléfono debe tener exactamente 9 dígitos.',
            'clie_telefono.unique' => 'El Teléfono ya está registrado.',
            'clie_correo.required' => 'El campo Correo Electrónico es obligatorio.',
            'clie_correo.email' => 'El campo Correo Electrónico no es válido.',
            'clie_correo.max' => 'El campo Correo Electrónico no debe exceder los 100 caracteres.',
            'clie_correo.unique' => 'El Correo Electrónico ya está registrado.',
        ];
    }
}
