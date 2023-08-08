<?php

namespace App\Http\Controllers\Planta;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoRequest;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\GradoInstruccion;
use App\Models\Profesion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Planta/Empleado/index', [
            'data' => Empleado::getEmpleadosPlanta($request, $this->currentUser->user_plan_id),
            'cargos' => Cargo::select('carg_id', 'carg_nombre')->get(),
            'profesiones' => Profesion::select('prof_id', 'prof_nombre')->get(),
            'gradosInstruccion' => GradoInstruccion::select('gins_id', 'gins_nombre')->get(),
        ]);
    }

    public function store(EmpleadoRequest $request)
    {
        $data = $request->all();
        Empleado::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(EmpleadoRequest $request, Empleado $empleado)
    {
        $data = $request->all();
        $empleado->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
