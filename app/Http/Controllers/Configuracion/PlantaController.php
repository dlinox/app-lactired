<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantaController extends Controller
{
    public function index()
    {

        return  Inertia::render('Configuracion/Planta/index');
    }
}
