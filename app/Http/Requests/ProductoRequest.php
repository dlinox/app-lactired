<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->producto ? $this->producto->prod_id : null;

        return [
            'prod_nombre' => 'required|string|unique:productos,prod_nombre,' . $productId . ',prod_id,prod_plan_id,' . $this->input('prod_plan_id'),
            'prod_stock' => 'required|integer',
            'prod_medida' => 'required|numeric',
            'prod_umed_id' => 'required|exists:unidad_medidas,umed_id',
            'prod_tpro_id' => 'required|exists:tipo_productos,tpro_id',
            'prod_plan_id' => 'required|exists:plantas,plan_id',
        ];
    }

    public function messages()
    {
        return [
            'prod_nombre.required' => 'El nombre es obligatorio.',
            'prod_nombre.string' => 'El nombre debe ser una cadena de texto.',
            'prod_nombre.unique' => 'El nombre ya está en uso en esta planta.',
            'prod_stock.required' => 'El stock es obligatorio.',
            'prod_stock.integer' => 'El stock debe ser un número entero.',
            'prod_medida.required' => 'La medida es obligatoria.',
            'prod_medida.numeric' => 'La medida debe ser un númera.',
            'prod_umed_id.required' => 'La unidad de medida es obligatoria.',
            'prod_umed_id.exists' => 'La unidad de medida no es válida.',
            'prod_tpro_id.required' => 'El tipo de producto es obligatorio.',
            'prod_tpro_id.exists' => 'El tipo de producto no es válido.',
            'prod_plan_id.required' => 'La planta es obligatoria.',
            'prod_plan_id.exists' => 'La planta no es válida.',
        ];
    }
}
