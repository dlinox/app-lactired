<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insumo;
use App\Models\Planta;
use App\Models\Producto;
use App\Models\TipoProducto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getPlantas(): JsonResponse
    {

        $plantas = Planta::select('plan_id', 'plan_razon_social', 'plan_ruc', 'plan_tipo_planta', 'plan_latitud', 'plan_longitud', 'plan_ubig_id')->get();
        return response()->json($plantas);
    }

    public function getPlanta($planta): JsonResponse
    {
        $_planta = Planta::find($planta);
        return response()->json($_planta);
    }

    public function getProductos(): JsonResponse
    {
        $_planta = Producto::all();
        return response()->json($_planta);
    }

    public function getProducto($producto): JsonResponse
    {
        $_producto = Producto::find($producto);
        return response()->json($_producto);
    }


    public function getTipoProductos(): JsonResponse
    {
        $_planta = TipoProducto::all();
        return response()->json($_planta);
    }

    public function getProductosPlanta($planta): JsonResponse
    {
        $_planta = Producto::where('prod_plan_id', $planta)->get();
        return response()->json($_planta);
    }


    public function getInsumos(): JsonResponse
    {
        $_planta = Insumo::all();
        return response()->json($_planta);
    }
}
