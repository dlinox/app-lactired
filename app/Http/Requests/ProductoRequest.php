<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->input('prod_id');

        return [
            'prod_nombre' => [
                'required',

                Rule::unique('productos', 'prod_nombre')->ignore($productId, 'prod_id')->where(function ($query) {
                    return $query->where('prod_plan_id',  Auth::user()->user_plan_id);
                }),
            ],
            'prod_stock' => 'required|integer',
            'prod_decripcion_tecnica' => 'required',
            'prod_medida' => 'required|numeric',
            'prod_umed_id' => 'required|exists:unidad_medidas,umed_id',
            'prod_tpro_id' => 'required|exists:tipo_productos,tpro_id',
            // 'prod_plan_id' => 'required|exists:plantas,plan_id',
        ];
    }

    public function messages()
    {
        return [
            'prod_decripcion_tecnica' => 'La descripcion es obligatorio',
            'prod_nombre.required' => 'El nombre es obligatorio.',
            'prod_nombre.unique' => 'El nombre ya está en uso en esta planta. ' .  $this->input('prod_id'),
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
