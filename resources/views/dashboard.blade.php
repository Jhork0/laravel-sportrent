<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel Principal - SportRent') }}
            </h2>
            <a href="{{ route('canchas.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                + Agregar Nueva Cancha
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($canchas as $cancha)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        @if($cancha->foto)
                            <img src="{{ asset('storage/' . $cancha->foto) }}" alt="{{ $cancha->nombre_cancha }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                Sin imagen disponible
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900">{{ $cancha->nombre_cancha }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $cancha->tipo_cancha }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-indigo-600 font-bold text-lg">${{ number_format($cancha->valor_hora, 0, ',', '.') }} / h</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $cancha->estado == 'disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($cancha->estado) }}
                                </span>
                            </div>

                            <p class="text-gray-500 text-sm mt-3">
                                <i class="fas fa-map-marker-alt"></i> {{ $cancha->direccion_cancha }}
                            </p>

                            <a href="{{ route('canchas.show', $cancha->id_cancha) }}" 
   class="mt-6 w-full block text-center bg-gray-800 text-white py-2 rounded-md hover:bg-gray-900 transition">
    Ver Detalles / Reservar
</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-lg shadow">
                        <p class="text-gray-500 italic">Aún no hay canchas registradas en Montería.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>