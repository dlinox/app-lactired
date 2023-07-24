<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = User::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        return Inertia::render('Seguridad/Usuario/index', [
            'items' => $items,
            'headers' => $this->user->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        User::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(UserRequest $request, User $usuario)
    {
        $data = $request->all();
        $usuario->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
