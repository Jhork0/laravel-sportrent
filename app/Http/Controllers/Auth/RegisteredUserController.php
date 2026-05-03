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
        'tipo_cuenta' => ['required', 'in:usuario,proveedor'],
        'cedula_persona' => ['required', 'string', 'max:20', 'unique:persona,cedula_persona'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:persona,correo'], 
        'direccion' => ['required', 'string', 'max:255'],
        'telefono' => ['required', 'string', 'max:20'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $nombres = explode(' ', $request->name);
    
    // Usaremos una transacción para que si algo falla, no quede una Persona huérfana
    $user = \DB::transaction(function () use ($request, $nombres) {
    
    // 1. Crear Persona
    \App\Models\Persona::create([
        'cedula_persona' => $request->cedula_persona,
        'primer_nombre'  => $nombres[0] ?? '',
        'segundo_nombre' => $nombres[1] ?? '',
        'primer_apellido'=> $nombres[2] ?? '',
        'segundo_apellido'=> $nombres[3] ?? '',
        'correo'         => $request->email,
        'direccion'      => $request->direccion,
        'telefono'       => $request->telefono,
    ]);

    // 2. SIEMPRE crear usuario (esto es lo importante)
    $user = \App\Models\User::create([
        'cedula_persona' => $request->cedula_persona,
        'usuario_login'  => $request->email,
        'contrasena'     => Hash::make($request->password),
        'estado'         => 'activo',
    ]);

    // 3. Si es proveedor, crear registro adicional
    if ($request->tipo_cuenta === 'proveedor') {
        \App\Models\Proveedor::create([
            'cedula_propietario' => $request->cedula_persona,
            'usuario_login'      => $request->email,
            'contrasena'         => $user->contrasena, // reutiliza hash
            'tipo_documento'     => 'CC',
        ]);
    }

    return $user; 
});

    // 3. Login y Evento
    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard'));
}
}
