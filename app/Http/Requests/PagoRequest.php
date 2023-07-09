<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'pago_numero' => 'required|string',
            'pago_monto' => 'required|numeric',
            'pago_fecha' => 'required|date',
            'pago_prov_id' => 'required|integer',
            'pago_plan_id' => 'required|integer',

            'pago_detalle' => 'required|array|min:1',
            'pago_detalle.*.comp_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'pago_numero.required' => 'El número de pago es requerido',
            'pago_monto.required' => 'El monto de pago es requerido',
            'pago_fecha.required' => 'La fecha de pago es requerida',
            'pago_prov_id.required' => 'El ID del proveedor es requerido',
            'pago_plan_id.required' => 'El ID del plan es requerido',

            'pago_detalle.required' => 'Se requiere al menos un detalle de pago',
            'pago_detalle.min' => 'Se requiere al menos un detalle de pago',
            'pago_detalle.*.comp_id.required' => 'El ID de la compra es requerido',
        ];
    }
}
