<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Líneas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">Editar Línea</h2>
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

                    <form action="{{ route('lineas.update', $linea->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="flex items-center">
                                <label for="id_linea" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">ID Seguro</label>
                                <input type="text" name="id_linea" id="id_linea" value="{{ $linea->hashed_id }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" readonly>
                            </div>

                            <div class="flex items-center">
                                <label for="nombre" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $linea->nombre) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>
                            <script>
                                document.getElementById('nombre').addEventListener('input', function (e) {
                                    let inputValue = e.target.value;
                                    e.target.value = inputValue.replace(/^(.*?)([a-zA-ZÁÉÍÓÚáéíóú])/, function(_, prefix, firstLetter) {
                                        return prefix + firstLetter.toUpperCase();
                                    });
                                });
                            </script>


                            <div class="flex items-center">
                                <label for="id_producto" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Producto asociado</label>
                                <select name="id_producto" id="id_producto" class="form-control w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                    <option value="" disabled>Seleccione un Producto</option>
                                    @foreach($Productos as $producto)
                                        <option value="{{ $producto->id_producto }}" {{ $producto->id_producto == $linea->id_producto ? 'selected' : '' }}>{{ $producto->nombre }}</option>
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
                        <a href="{{ route('lineas.index') }}">
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
