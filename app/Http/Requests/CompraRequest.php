<?php

namespace App\Http\Requests;

use App\Models\Compra;
use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comp_serie' => 'required|string|max:4',
            'comp_numero' => 'required|string|max:10',
            'comp_numero' => [
                'required',
                function ($attribute, $value, $fail) {
                    $count = Compra::where([
                        'comp_serie' => $this->comp_serie,
                        'comp_numero' => $this->comp_numero,
                        'comp_plan_id' => $this->comp_plan_id,
                    ])->count();

                    if ($count > 0) {
                        $fail($this->comp_serie . '-' .  $this->comp_numero . ' ya existe.');
                    }
                },
            ],

            //'vent_correlativo' => 'string|max:15',
            'comp_fecha' => 'required|date',
            'comp_subtotal' => 'required|numeric',
            'comp_total' => 'required|numeric',
            'comp_igv' => 'required|numeric',
            'comp_estado' => 'boolean',
            'comp_tipo_pago' => 'required|boolean',
            'comp_prov_id' => 'required|integer|exists:proveedores,prov_id',
            'comp_plan_id' => 'required|integer|exists:plantas,plan_id',
            'comp_tipo_comprobante' => 'required|in:FACTURA,BOLETA,NOTA DE CREDITO,NOTA DE DEBITO,RECIBO POR HONORARIOS,GUIA DE REMISION',
            //DETALLES
            'comp_detalle.*.insu_id' => 'required|integer|exists:insumos,insu_id',
            'comp_detalle.*.cantidad' => 'required|integer',
            'comp_detalle.*.precio' => 'required|numeric',
            'comp_detalle.*.importe' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'comp_serie.required' => 'El campo serie es requerido.',
            'comp_serie.max' => 'El campo serie debe tener máximo :max caracteres.',
            'comp_numero.required' => 'El campo número es requerido.',
            'comp_numero.max' => 'El campo número debe tener máximo :max caracteres.',
            //'comp_correlativo.required' => 'El campo correlativo es requerido.',
            // 'comp_correlativo.max' => 'El campo correlativo debe tener máximo :max caracteres.',
            'comp_fecha.required' => 'El campo fecha es requerido.',
            'comp_fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'comp_subtotal.required' => 'El campo subtotal es requerido.',
            'comp_subtotal.numeric' => 'El campo subtotal debe ser un valor numérico.',

            'comp_igv.required' => 'El campo subtotal es requerido.',
            'comp_igv.numeric' => 'El campo subtotal debe ser un valor numérico.',

            'comp_total.required' => 'El total es requerido.',
            'comp_total.numeric' => 'El total debe ser un valor numérico.',
            'comp_estado.required' => 'El estado es requerido.',
            'comp_estado.boolean' => 'El estado debe ser un valor booleano.',
            'comp_tipo_pago.required' => 'El campo tipo de pago es requerido.',
            'comp_tipo_pago.boolean' => 'El campo tipo de pago debe ser un valor booleano.',
            'comp_prov_id.required' => 'El proveedor es requerido.',
            'comp_prov_id.integer' => 'El proveedor es incorrecto.',
            'comp_prov_id.exists' => 'El proveedor no existe.',
            'comp_plan_id.required' => 'El campo ID del plan es requerido.',
            'comp_plan_id.integer' => 'El campo ID del plan debe ser un valor entero.',
            'comp_plan_id.exists' => 'El ID del plan especificado no existe en la tabla plantas.',
            'comp_tipo_comprobante.required' => 'El campo tipo de comprobante es requerido.',
            'comp_tipo_comprobante.in' => 'El campo tipo de comprobante debe ser uno de los siguientes valores: FACTURA, BOLETA, NOTA DE CREDITO, NOTA DE DEBITO, RECIBO POR HONORARIOS, GUIA DE REMISION.',
            'comp_detalle.*.cantidad.required' => 'La cantidad es requerido.',
            'comp_detalle.*.cantidad.integer' => 'La cantidad debe ser un valor entero.',
            'comp_detalle.*.precio.required' => 'El precio es requerido.',
            'comp_detalle.*.precio.numeric' => 'El precio debe ser un valor numérico.',
            'comp_detalle.*.importe.required' => 'El importe es requerido.',
            'comp_detalle.*.importe.numeric' => 'El importe debe ser un valor numérico.',
            'comp_detalle.*.insu_id.required' => 'El insumo es requerido.',
            'comp_detalle.*.insu_id.integer' => 'El insumo un valor entero.',
            'comp_detalle.*.insu_id.exists' => 'El insumo existe en la tabla insumos.',
        ];
    }
}
