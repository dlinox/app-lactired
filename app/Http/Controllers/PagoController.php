<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{

    public function create(Request $request)
    {
        $defaults = [
            'fecha' => date('Y-m-d'),
            'numero' => $this->getNextNumero(),
        ];

        return Inertia::render('Pago/create', [
            'defaults' => $defaults
        ]);
    }

    protected function getNextNumero()
    {
        $maxVentNumero = Pago::max('pago_numero');
        $maxVentNumero = $maxVentNumero ? $maxVentNumero + 1 : 1;
        return str_pad($maxVentNumero, 10, '0', STR_PAD_LEFT);
    }
}
