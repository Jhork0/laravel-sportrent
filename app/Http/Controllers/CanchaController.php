<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ¡FALTA ESTA LÍNEA!

class CanchaController extends Controller
{
    // Muestra el formulario
    public function create()
    {
        return view('canchas.create');
    }

    // Guarda la cancha en la BD
    public function store(Request $request)
    {
        $request->validate([
            'nombre_cancha'    => 'required|string|max:100',
            'tipo_cancha'      => 'required|in:Futbol,Basketbol,Tennis,Padel,Sintetica', 
            'valor_hora'       => 'required|numeric',
            'hora_apertura'    => 'required',
            'hora_cierre'      => 'required',
            'foto'             => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'direccion_cancha' => 'required|string|max:255',
            'descripcion'      => 'required|string',
        ]);

        // 1. Obtener el proveedor actual logueado
        $cedula = auth()->user()->cedula_persona;
        $proveedor = \App\Models\Proveedor::where('cedula_propietario', $cedula)->first();

        if (!$proveedor) {
            return back()->withErrors(['error' => 'No se encontró un perfil de proveedor asociado.']);
        }

        // Construir el array de datos
        $data = [
            'nombre_cancha'    => $request->nombre_cancha,
            'tipo_cancha'      => $request->tipo_cancha,
            'descripcion'      => $request->descripcion,
            'valor_hora'       => $request->valor_hora,
            'hora_apertura'    => $request->hora_apertura . ':00', // Formato HH:MM:SS
            'hora_cierre'      => $request->hora_cierre . ':00',
            'estado'           => $request->has('estado') ? 'disponible' : 'no_disponible',
            'direccion_cancha' => $request->direccion_cancha,
        ];

        // Manejo de imagen
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('canchas', 'public');
        }

        // 2. Usar transacción para asegurar la consistencia
        DB::transaction(function () use ($data, $proveedor) {
            // Crear la cancha
            $cancha = Cancha::create($data);

            // Insertar en la tabla intermedia 'administra'
            DB::table('administra')->insert([
                'id_admin'           => substr(md5(uniqid()), 0, 10), // Genera string único de 10 caracteres
                'cedula_propietario' => $proveedor->cedula_propietario,
                'id_cancha'          => $cancha->id_cancha,
            ]);
        });

        return redirect()->route('dashboard')->with('success', '¡Cancha registrada con éxito!');
    }

    public function show($id)
{
    $cancha = Cancha::findOrFail($id);
    
    // Verificar si el usuario es dueño
    $esDueno = false;
    if (auth()->check()) {
        $cedula = auth()->user()->cedula_persona;
        $esDueno = \App\Models\Administra::where('id_cancha', $id)
            ->where('cedula_propietario', $cedula)
            ->exists();
    }

    return view('canchas.show', compact('cancha', 'esDueno'));
}

    public function dashboard()
    {
        // Obtenemos todas las canchas de la base de datos
        $canchas = Cancha::all(); 
        
        // Retornamos la vista dashboard con los datos
        return view('dashboard', compact('canchas'));
    }

    public function misCanchas()
    {
        // Obtener la cédula del usuario logueado
        $cedula = auth()->user()->cedula_persona;
        
        // Buscar el proveedor asociado a esa cédula
        $proveedor = \App\Models\Proveedor::where('cedula_propietario', $cedula)->first();

        // Obtener las canchas, o devolver una colección vacía si no es proveedor
        $canchas = $proveedor ? $proveedor->canchas : collect();

        return view('canchas.mis-canchas', compact('canchas'));
    }
}