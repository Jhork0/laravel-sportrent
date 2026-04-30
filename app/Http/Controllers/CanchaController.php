<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;

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
        'nombre_cancha' => 'required|string|max:100',
        'tipo_cancha'   => 'required|in:Futbol,Basketbol,Tennis,Padel,Sintetica', 
        'valor_hora'    => 'required|numeric',
        'hora_apertura' => 'required',
        'hora_cierre'   => 'required',
        'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'direccion_cancha' => 'required|string|max:255',
        'descripcion'   => 'required|string',
    ]);

    // Construir el array manualmente
    $data = [
        'nombre_cancha'    => $request->nombre_cancha,
        'tipo_cancha'      => $request->tipo_cancha,
        'descripcion'      => $request->descripcion,
        'valor_hora'       => $request->valor_hora,
        'hora_apertura'    => $request->hora_apertura . ':00', // Aseguramos formato HH:MM:SS
        'hora_cierre'      => $request->hora_cierre . ':00',
        'estado'           => $request->has('estado') ? 'disponible' : 'no_disponible',
        'direccion_cancha' => $request->direccion_cancha,
    ];

    // Manejo de imagen
    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')->store('canchas', 'public');
    }

    // Insertar
    Cancha::create($data);

    return redirect()->route('dashboard')->with('success', '¡Cancha registrada con éxito!');
}
    // app/Http/Controllers/CanchaController.php

public function dashboard()
{
    // Obtenemos todas las canchas de la base de datos
    $canchas = Cancha::all(); 
    
    // Retornamos la vista dashboard con los datos
    return view('dashboard', compact('canchas'));
}
}   