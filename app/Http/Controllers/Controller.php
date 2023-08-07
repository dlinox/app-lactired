<?php

namespace App\Http\Controllers;

use App\Models\Ubigeo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $user2;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user2 = Auth::user();
            return $next($request);
        });
    }


    public function ubigeoAutocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // $results = Ubigeo::Where('ubig_completo', 'like', '%' . $searchTerm . '%')
            //     ->limit(30)->get();

            $ubigCompletos = Ubigeo::whereRaw("CONCAT(ubig_departamento, ', ', ubig_provincia, ', ', ubig_distrito) LIKE '%$searchTerm%'")
                ->limit(30)->get();
        }
        return response()->json($ubigCompletos);
    }
}
