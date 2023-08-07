<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {

        $insumoId = $this->input('insu_id');

        return [
            'insu_nombre' => 'required|string|unique:insumos,insu_nombre,' . $insumoId . ',insu_id,insu_plan_id,' . Auth::user()->user_plan_id,
            'insu_stock' => 'required|integer',
            'insu_medida' => 'required|numeric',
            'insu_umed_id' => 'required|exists:unidad_medidas,umed_id',
        ];
    }

    public function messages()
    {
        return [
            'insu_nombre.required' => 'El nombre del insumo es obligatorio.',
            'insu_nombre.string' => 'El nombre del insumo debe ser una cadena de texto.',
            'insu_stock.required' => 'El stock del insumo es obligatorio.',
            'insu_stock.integer' => 'El stock del insumo debe ser un número entero.',
            'insu_medida.required' => 'La medida del insumo es obligatoria.',
            'insu_medida.numeric' => 'La medida del insumo debe ser un número.',
            'insu_umed_id.required' => 'El ID de unidad de medida es obligatorio.',
            'insu_umed_id.exists' => 'El ID de unidad de medida no existe en la tabla unidad_medidas.',
            'insu_nombre.unique' => 'El nombre del insumo ya está en uso para esta planta.',
        ];
    }
}
