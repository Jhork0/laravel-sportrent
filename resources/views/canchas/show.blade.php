<x-app-layout>
    <div class="max-w-5xl mx-auto py-12 px-4">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <img src="{{ asset('storage/' . $cancha->foto) }}" class="w-full h-80 object-cover rounded-lg">
            <h1 class="text-4xl font-bold mt-6">{{ $cancha->nombre_cancha }}</h1>
            <p class="text-gray-600 mt-2">{{ $cancha->descripcion }}</p>
        </div>

        @if($esDueno)
            <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                <h2 class="text-xl font-bold text-blue-900">Panel de Control de Propietario</h2>
                <p>Usted es el administrador de esta cancha. Puede ver estadísticas y gestionar mantenimientos aquí.</p>
                </div>
        @else
            <div class="mt-8 bg-white p-8 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6">Reservar Horario</h2>
                <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                    @for($hora = (int)$cancha->hora_apertura; $hora < (int)$cancha->hora_cierre; $hora++)
                        <button class="p-3 border rounded hover:bg-indigo-600 hover:text-white transition">
                            {{ $hora }}:00
                        </button>
                    @endfor
                </div>
            </div>
        @endif
    </div>
</x-app-layout>