<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getPlantas() : JsonResponse {
        
        $plantas = Planta::all();
        return response()->json($plantas);
    }
}
