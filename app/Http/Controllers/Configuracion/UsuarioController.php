<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {

        return  Inertia::render('Configuracion/Usuario/index');
    }
}
