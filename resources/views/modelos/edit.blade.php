<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modelos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">Editar Modelo</h2>
                    @if ($errors->any())
                        <div id="error-messages" class="text-black dark:text-gray-200 rounded-lg p-4 mb-4">
                            <ul class="text-center">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xl font-bold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <script>
                        setTimeout(function() {
                            var errorMessages = document.getElementById('error-messages');
                            if (errorMessages) {
                                errorMessages.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    @if (session('success'))
                        <div class="px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('modelos.update', $modelo->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="flex items-center">
                                <label for="id_modelo" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">ID Seguro</label>
                                <input type="text" name="id_modelo" id="id_modelo" value="{{ $modelo->hashed_id }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" readonly>
                            </div>

                            <div class="flex items-center">
                                <label for="codigo" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Código</label>
                                <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $modelo->codigo) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="descripcion" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Descripción</label>
                                <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $modelo->descripcion) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="id_linea" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Línea asociada</label>
                                <select name="id_linea" id="id_linea" class="form-control w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                    <option value="" disabled>Seleccione una Línea</option>
                                    @foreach($Lineas as $linea)
                                        <option value="{{ $linea->id_linea }}" {{ $linea->id_linea == $modelo->id_linea ? 'selected' : '' }}>{{ $linea->linea_nombre }} - Producto: {{ $linea->producto_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-4 mt-6">
                            <x-primary-button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                                Actualizar
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('modelos.index') }}">
                            <x-danger-button class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                                Cancelar
                            </x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
