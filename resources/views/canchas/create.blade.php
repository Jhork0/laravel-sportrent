<x-guest-layout>
    @push('styles')
    <style>
        /* Forzamos que el contenedor del layout no limite el ancho */
        /* Buscamos el div que suele tener el max-w-md y lo liberamos */
        .min-h-screen > div:nth-child(2) {
            max-width: 100% !important;
            width: 100% !important;
        }

        /* Tu lógica de espaciado inspirada en React */
        .courtform-wrapper {
            padding-left: 1.25rem;
        }
        
        @media (min-width: 768px) {
            .courtform-wrapper {
                padding-left: 2rem;
            }
        }

        /* Estilo para que el formulario se vea integrado con el fondo */
        .glass-form {
            background: rgba(255, 255, 255, 0.9); /* Casi blanco para legibilidad */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
    @endpush

    <div class="min-h-screen flex items-center justify-center py-12 bg-cover bg-center bg-fixed">
        <div class="w-full max-w-7xl px-4 sm:px-6 lg:px-8 courtform-wrapper">
            
            <form action="{{ route('canchas.store') }}" method="POST" enctype="multipart/form-data" 
                  class="glass-form rounded-xl shadow-2xl w-full p-6 md:p-12">
                @csrf

                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-3xl font-bold text-blue-900">Registrar Nueva Cancha</h2>
                    <p class="text-gray-600">Completa la información para publicar tu escenario deportivo.</p>
                </div>

                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Nombre de la cancha </label>
                            <input type="text" name="nombre_cancha" placeholder="Ej: Cancha Principal" required
                                   value="{{ old('nombre_cancha') }}"
                                   class="text-lg p-4 w-full border border-blue-200 text-blue-800 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nombre_cancha') border-red-500 @enderror">
                        </div>

                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Dirección </label>
                            <input type="text" name="direccion_cancha" placeholder="Ej: Av. Principal 123" required
                                   class="text-lg p-4 w-full border border-blue-200 text-blue-800 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Precio por hora </label>
                            <input type="number" name="valor_hora" placeholder="0.00" step="0.01" required
                                   class="text-lg p-4 w-full border border-blue-200 text-blue-800 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Categoría </label>
                            <select name="tipo_cancha" required
                                    class="text-lg p-4 w-full border border-blue-200 text-blue-800 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="Futbol">Fútbol</option>
                                <option value="Basketbol">Basketbol</option>
                                <option value="Tennis">Tennis</option>
                                <option value="Padel">Padel</option>

                            </select>
                        </div>

                      

                        <div class="space-y-3">
    <label class="block text-gray-700 font-bold text-lg">Imagen de la cancha</label>

    {{-- Preview de imagen --}}
    <div id="image-preview-container" class="hidden w-full rounded-lg overflow-hidden border-2 border-blue-300 bg-blue-50" style="max-height: 220px;">
        <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover" style="max-height: 220px;">
    </div>

    <label for="foto" id="upload-label" class="flex items-center justify-center w-full h-[60px] bg-blue-50 border-2 border-dashed border-blue-300 rounded-lg cursor-pointer hover:bg-blue-100 transition-all">
        <span id="file-name-display" class="text-blue-700 text-sm font-medium">Click para subir foto</span>
        <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
    </label>
</div>
                    </div>

                    <div class="space-y-4">
                        <label for="descripcion" class="block text-gray-700 font-bold text-lg">Descripción (opcional)</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="w-full p-4 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 resize-none text-lg"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Hora de apertura *</label>
                            <input type="time" name="hora_apertura" required
                                   class="w-full p-4 text-lg rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-lg">Hora de cierre *</label>
                            <input type="time" name="hora_cierre" required
                                   class="w-full p-4 text-lg rounded-lg border border-blue-200 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pt-6">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" name="estado" id="estado" value="disponible" checked
                                   class="w-6 h-6 text-blue-600 rounded focus:ring-blue-500">
                            <label for="estado" class="text-gray-700 font-bold text-xl cursor-pointer">Disponible para reservas</label>
                        </div>

                        <button type="submit" id="btn-submit"
                                class="bg-blue-700 text-white font-black py-4 px-12 rounded-xl hover:bg-blue-800 transition-all text-2xl shadow-xl transform hover:scale-105">
                            GUARDAR CANCHA
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('foto').addEventListener('change', function () {
        const file = this.files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const previewImg = document.getElementById('image-preview');
        const fileNameDisplay = document.getElementById('file-name-display');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
            fileNameDisplay.textContent = '📷 ' + file.name;
        } else {
            previewContainer.classList.add('hidden');
            fileNameDisplay.textContent = 'Click para subir foto';
        }
    });
</script>
</x-guest-layout>