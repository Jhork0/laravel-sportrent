<form action="{{ route('canchas.store') }}" method="POST" enctype="multipart/form-data" class="p-6 bg-white shadow-md rounded">
    @csrf
    <div>
        <label>Nombre de la Cancha</label>
        <input type="text" name="nombre_cancha" class="border p-2 w-full" required>
    </div>

    <div class="mt-4">
        <label>Tipo de Cancha</label>
        <select name="tipo_cancha" class="border p-2 w-full">
            <option value="Futbol 5">Futbol 5</option>
            <option value="Sintetica">Sintética</option>
            </select>
    </div>

    <div class="mt-4">
        <label>Valor por Hora</label>
        <input type="number" name="valor_hora" step="0.01" class="border p-2 w-full" required>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
            <label>Hora Apertura</label>
            <input type="time" name="hora_apertura" class="border p-2 w-full" required>
        </div>
        <div>
            <label>Hora Cierre</label>
            <input type="time" name="hora_cierre" class="border p-2 w-full" required>
        </div>
    </div>

    <div class="mt-4">
        <label>Foto de la cancha</label>
        <input type="file" name="foto" class="w-full">
    </div>

    <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">Guardar Cancha</button>
</form>