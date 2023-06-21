<?php

namespace App\Http\Requests;

use App\Models\Venta;
use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vent_serie' => 'required|string|max:4',
            'vent_numero' => 'required|string|max:10',
            'vent_numero' => [
                'required',
                function ($attribute, $value, $fail) {
                    $count = Venta::where([
                        'vent_serie' => $this->vent_serie,
                        'vent_numero' => $this->vent_numero,
                        'vent_plan_id' => $this->vent_plan_id,
                    ])->count();

                    if ($count > 0) {
                        $fail($this->vent_serie . '-' .  $this->vent_numero . ' ya existe.');
                    }
                },
            ],

            //'vent_correlativo' => 'string|max:15',
            'vent_fecha' => 'required|date',
            'vent_subtotal' => 'required|numeric',
            'vent_total' => 'required|numeric',
            'vent_estado' => 'boolean',
            'vent_tipo_pago' => 'required|boolean',
            'vent_clie_id' => 'required|integer|exists:clientes,clie_id',
            'vent_plan_id' => 'required|integer|exists:plantas,plan_id',
            'vent_tipo_comprobante' => 'required|in:FACTURA,BOLETA,NOTA DE CREDITO,NOTA DE DEBITO,RECIBO POR HONORARIOS,GUIA DE REMISION',
            //DETALLES
            'vent_detalle.*.prod_id' => 'required|integer|exists:productos,prod_id',
            'vent_detalle.*.cantidad' => 'required|integer',
            'vent_detalle.*.precio' => 'required|numeric',
            'vent_detalle.*.importe' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'vent_serie.required' => 'El campo serie es requerido.',
            'vent_serie.max' => 'El campo serie debe tener máximo :max caracteres.',
            'vent_numero.required' => 'El campo número es requerido.',
            'vent_numero.max' => 'El campo número debe tener máximo :max caracteres.',
            'vent_correlativo.required' => 'El campo correlativo es requerido.',
            'vent_correlativo.max' => 'El campo correlativo debe tener máximo :max caracteres.',
            'vent_fecha.required' => 'El campo fecha es requerido.',
            'vent_fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'vent_subtotal.required' => 'El campo subtotal es requerido.',
            'vent_subtotal.numeric' => 'El campo subtotal debe ser un valor numérico.',
            'vent_total.required' => 'El campo total es requerido.',
            'vent_total.numeric' => 'El campo total debe ser un valor numérico.',
            'vent_estado.required' => 'El campo estado es requerido.',
            'vent_estado.boolean' => 'El campo estado debe ser un valor booleano.',
            'vent_tipo_pago.required' => 'El campo tipo de pago es requerido.',
            'vent_tipo_pago.boolean' => 'El campo tipo de pago debe ser un valor booleano.',
            'vent_clie_id.required' => 'El campo ID del cliente es requerido.',
            'vent_clie_id.integer' => 'El campo ID del cliente debe ser un valor entero.',
            'vent_clie_id.exists' => 'El ID del cliente especificado no existe en la tabla clientes.',
            'vent_plan_id.required' => 'El campo ID del plan es requerido.',
            'vent_plan_id.integer' => 'El campo ID del plan debe ser un valor entero.',
            'vent_plan_id.exists' => 'El ID del plan especificado no existe en la tabla plantas.',
            'vent_tipo_comprobante.required' => 'El campo tipo de comprobante es requerido.',
            'vent_tipo_comprobante.in' => 'El campo tipo de comprobante debe ser uno de los siguientes valores: FACTURA, BOLETA, NOTA DE CREDITO, NOTA DE DEBITO, RECIBO POR HONORARIOS, GUIA DE REMISION.',
            'vent_detalle.*.cantidad.required' => 'El campo cantidad en los detalles de venta es requerido.',
            'vent_detalle.*.cantidad.integer' => 'El campo cantidad en los detalles de venta debe ser un valor entero.',
            'vent_detalle.*.precio.required' => 'El campo precio en los detalles de venta es requerido.',
            'vent_detalle.*.precio.numeric' => 'El campo precio en los detalles de venta debe ser un valor numérico.',
            'vent_detalle.*.importe.required' => 'El campo importe en los detalles de venta es requerido.',
            'vent_detalle.*.importe.numeric' => 'El campo importe en los detalles de venta debe ser un valor numérico.',
            'vent_detalle.*.prod_id.required' => 'El campo ID del producto en los detalles de venta es requerido.',
            'vent_detalle.*.prod_id.integer' => 'El campo ID del producto en los detalles de venta debe ser un valor entero.',
            'vent_detalle.*.prod_id.exists' => 'El ID del producto especificado en los detalles de venta no existe en la tabla productos.',
        ];
    }
}
