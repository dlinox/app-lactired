<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    
    public function index() {
        
        return Inertia::render('Auth/Login');
    }
    public function signIn(Request $request) {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // El usuario ha sido autenticado correctamente
            return redirect()->intended('/');
        } else {
            // Las credenciales son inválidas
            return redirect()->back()->withErrors(['message' => 'Credenciales inválidas']);
        }

    }
    public function signOut() {

        Auth::logout();
        
        return redirect('/login');

    }
}

