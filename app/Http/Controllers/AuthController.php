<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validamos los campos personalizados de tu tabla 'usuario'
        $credentials = $request->validate([
            'usuario_login' => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        // Intentamos autenticar. Laravel comparará 'usuario_login' 
        // y usará 'getAuthPassword()' de tu modelo para verificar la 'contrasena'
        if (Auth::attempt(['usuario_login' => $credentials['usuario_login'], 'password' => $credentials['contrasena']])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'usuario_login' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }
}