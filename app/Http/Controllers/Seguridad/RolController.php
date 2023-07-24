<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolRequest;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Seguridad/Rol/index', [
            'permisos' => $this->groupedPermissions(),
            'data' => Rol::getRoles($request),
        ]);
    }

    public function store(RolRequest $request)
    {
        $data = $request->all();
        $data['guard_name'] = 'admin';
        $item =  Rol::create($data);
        return redirect()->back()->with(['success' => 'Elemento creado exitosamente.', 'data' => $item]);
    }

    public function update(RolRequest $request, Rol $role)
    {
        $data = $request->all();
        $role->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Rol $role)
    {

        $role->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function asignarPermisos(Request $request){

        $rol =  Role::find($request->rol);
        $rol->syncPermissions($request->permisos);
        return back()->with('success', 'Permisos actualizados.');

    }

    protected function groupedPermissions()
    {
        $data =  Permission::select('id', 'name', 'group_name')
        ->get();
        $groupedData = [];
        foreach ($data as $item) {
            $groupName = $item['group_name'];

            if (!isset($groupedData[$groupName])) {
                $groupedData[$groupName] = [];
            }
            $groupedData[$groupName][] = $item;
        }
        return $groupedData;
    }
}
