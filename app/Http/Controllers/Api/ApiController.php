<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getPlantas() : JsonResponse {
        
        $plantas = Planta::select('plan_id','plan_razon_social','plan_ruc','plan_tipo_planta')->get();
        return response()->json($plantas);
    }

    public function getPlanta(Planta $plata) : JsonResponse {
        
        return response()->json($plata);
    }
}
