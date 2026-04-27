<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // 1. Validamos usando tus campos: cedula y usuario_login
    $request->validate([
        'cedula_persona' => ['required', 'string', 'max:20', 'unique:usuario'],
        'usuario_login'  => ['required', 'string', 'max:100', 'unique:usuario'],
        'password'       => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // 2. Creamos el usuario en la tabla 'usuario'
    // Nota: Asegúrate de que la 'cedula_persona' ya exista en la tabla 'persona'
    // o crea ambas al tiempo.
    $user = User::create([
        'cedula_persona' => $request->cedula_persona,
        'usuario_login'  => $request->usuario_login,
        'contrasena'     => Hash::make($request->password), // Usamos 'contrasena'
        'estado'         => 'activo',
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}
