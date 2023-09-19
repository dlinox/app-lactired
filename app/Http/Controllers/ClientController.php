<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {

        return Inertia::render('Auth/RegisterClient');
    }

    public function store(ClienteRequest $request)
    {
        $data = $request->all();
        Cliente::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }
}
