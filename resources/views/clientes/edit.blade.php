<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">Editar Cliente</h2>
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

                    <form action="{{ route('clientes.update', $cliente->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="flex items-center">
                                <label for="id_cliente" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">ID Seguro</label>
                                <input type="text" name="id_cliente" id="id_cliente" value="{{ $cliente->hashed_id }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" readonly>
                            </div>

                            <div class="flex items-center">
                                <label for="nombre" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="apellidos" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="identificacion" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Identificación</label>
                                <input type="text" name="identificacion" id="identificacion" value="{{ old('identificacion', $cliente->identificacion) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="telefono" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Teléfono</label>
                                <input type="number" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="direccion" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Dirección</label>
                                <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="referencia" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Referencia</label>
                                <input type="text" name="referencia" id="referencia" value="{{ old('referencia', $cliente->referencia) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="municipio" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Municipio</label>
                                <input type="text" name="municipio" id="municipio" value="{{ old('municipio', $cliente->municipio) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <div class="flex items-center">
                                <label for="id_departamento" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Departamento</label>
                                <select name="id_departamento" id="id_departamento" class="form-control w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                    <option value="" disabled>Seleccione un Departamento</option>
                                    @foreach($Departamentos as $departamento)
                                        <option value="{{ $departamento->id_departamento }}" {{ $departamento->id_departamento == $cliente->id_departamento ? 'selected' : '' }}>{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="id_empresa" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Empresa (Opcional)</label>
                                <select name="id_empresa" id="id_empresa" class="form-control w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                    <option value="" disabled>Seleccione la Empresa</option>
                                    <option value="">Sin empresa</option>
                                    @foreach($Empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}" {{ $empresa->id_empresa == $cliente->id_empresa ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="cargo" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Cargo (Opcional)</label>
                                <input type="text" name="cargo" id="cargo" value="{{ old('cargo', $cliente->cargo) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        <div class="flex justify-center space-x-4 mt-6">
                            <x-primary-button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                                Actualizar
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('clientes.index') }}">
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
