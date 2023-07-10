<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcopioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comp_serie' => 'required',
            'comp_numero' => 'required',
            'comp_correlativo' => 'nullable',
            'comp_fecha' => 'required|date',
            'comp_subtotal' => 'required|numeric',
            'comp_total' => 'required|numeric',
            'comp_importe' => 'required|numeric',
            'comp_igv' => 'required|numeric',
            'comp_tipo_pago' => 'required',
            'comp_tipo' => 'required',
            'comp_estado_deuda' => 'required',
            'comp_imagen' => 'required|image|max:4096',
            'comp_plan_id' => 'required|integer',
            'comp_prov_id' => 'required|integer',
            'comp_tipo_comprobante' => 'required',
            'comp_detalle' => 'required|array',
            'comp_detalle.*.insu_id' => 'required|integer',
            'comp_detalle.*.cantidad' => 'required',
            'comp_detalle.*.precio' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'comp_serie' => 'serie',
            'comp_numero' => 'número',
            'comp_correlativo' => 'correlativo',
            'comp_fecha' => 'fecha',
            'comp_subtotal' => 'subtotal',
            'comp_total' => 'total',
            'comp_importe' => 'importe',
            'comp_igv' => 'IGV',
            'comp_tipo_pago' => 'tipo de pago',
            'comp_tipo' => 'tipo',
            'comp_estado_deuda' => 'estado de deuda',
            'comp_imagen' => 'imagen',
            'comp_plan_id' => 'planta',
            'comp_prov_id' => 'proveedor',
            'comp_tipo_comprobante' => 'tipo de comprobante',
            'comp_detalle' => 'detalle',
            'comp_detalle.*.insu_id' => 'ID de insumo',
            'comp_detalle.*.cantidad' => 'cantidad',
            'comp_detalle.*.precio' => 'precio',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de caracteres.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'image' => 'El archivo :attribute debe ser una imagen.',
            'max' => 'El tamaño máximo permitido para :attribute es de 4 MB.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'array' => 'El campo :attribute debe ser un arreglo.',
        ];
    }
}
