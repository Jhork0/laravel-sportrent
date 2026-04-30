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
use App\Models\Persona;
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
    $request->validate([
        'cedula_persona' => ['required', 'string', 'max:20', 'unique:persona,cedula_persona'],
        'name' => ['required', 'string', 'max:255'], // El nombre completo del input
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:persona,correo'], 
        'direccion' => ['required', 'string', 'max:255'],
        'telefono' => ['required', 'string', 'max:20'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Lógica para repartir el nombre completo en tus columnas de persona
    $nombres = explode(' ', $request->name);
    $primer_nombre = $nombres[0] ?? '';
    $segundo_nombre = $nombres[1] ?? '';
    $primer_apellido = $nombres[2] ?? '';
    $segundo_apellido = $nombres[3] ?? '';

    // PASO 1: Crear Persona con tus columnas exactas
    Persona::create([
        'cedula_persona' => $request->cedula_persona,
        'primer_nombre' => $primer_nombre,
        'segundo_nombre' => $segundo_nombre,
        'primer_apellido' => $primer_apellido,
        'segundo_apellido' => $segundo_apellido,
        'correo' => $request->email,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
    ]);

    // PASO 2: Crear Usuario
    $user = User::create([
        'cedula_persona' => $request->cedula_persona,
        'usuario_login' => $request->email, // Login con el correo
        'contrasena' => Hash::make($request->password),
        'estado' => 'activo',
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard'));
}
}
