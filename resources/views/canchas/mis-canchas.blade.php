<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Canchas Registradas') }}
        </h2>
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
                                Sin imagen
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900">{{ $cancha->nombre_cancha }}</h3>
                            <p class="text-sm text-gray-600">{{ $cancha->tipo_cancha }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-indigo-600 font-bold">${{ number_format($cancha->valor_hora, 0, ',', '.') }}</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $cancha->estado == 'disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($cancha->estado) }}
                                </span>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-2">
                                <a href="{{ route('canchas.edit', $cancha->id_cancha) }}" class="text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                                    Editar
                                </a>
                                <form action="{{ route('canchas.destroy', $cancha->id_cancha) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-lg shadow border-2 border-dashed">
                        <p class="text-gray-500">Aún no has registrado ninguna cancha.</p>
                        <a href="{{ route('canchas.create') }}" class="text-indigo-600 font-bold hover:underline">¡Registra tu primera cancha aquí!</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>