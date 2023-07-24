<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class Rol extends Model
{
    use HasFactory;

    protected $table  = 'roles';

    protected $fillable = [
        'name',
        'route_redirect',
        'guard_name',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public static $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Ruta base", 'value' => "route_redirect", 'short' => false, 'order' => 'ASC'],
    ];

    public static function getRoles(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Role::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $items = $query
            ->select(
                'id',
                'name',
                'route_redirect',
            )
            ->where('name', '!=', 'Super Admin')
            ->with('permissions:id,name')
            ->paginate($perPage)->appends($request->query());

        return [
            'items' => $items,
            'headers' => self::$headers,
            'filters' => [
                'search' => $request->search,
            ],
        ];
        // return self::all();
    }
}
