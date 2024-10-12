<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle de Checklist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">
                        Detalle del Checklist No. {{ $check->id_check }} - {{ \Carbon\Carbon::parse($check->created_at)->year }}
                    </h2>
                    @if(session('success'))
                        <div id="mensaje" class="alert alert-success">
                            <p class="text-center text-gray-500 dark:text-gray-400 mt-4">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <div id="mensaje" class="alert alert-danger">
                            <p class="text-center text-gray-500 dark:text-gray-400 mt-4">{{ session('error') }}</p>
                        </div>
                    @endif
                    <script>
                        setTimeout(function() {
                            var errorMessages = document.getElementById('mensaje');
                            if (errorMessages) {
                                errorMessages.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <div class="mt-6">
                        <form action="{{ route('detallecheck.store', ['hashedId' => $hashedId]) }}" method="POST">
                            @csrf
                            <table class="mt-6 w-full table-auto items-center">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Cliente</th>
                                    <th class="px-4 py-2">Equipo</th>
                                    <th class="px-4 py-2">Plan de Mantenimiento</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Observaciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($detallesCheck as $index => $detalle)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 text-center">
                                            ID {{ $detalle->controlDeManto->cliente->id_cliente+1000 }}-{{ \Carbon\Carbon::parse($detalle->controlDeManto->cliente->created_at)->year }} <br>
                                            {{ $detalle->controlDeManto->cliente->nombre }} {{ $detalle->controlDeManto->cliente->apellidos }} <br>
                                            {{ $detalle->controlDeManto->cliente->empresa->nombre }} <br>
                                            Tel: {{ $detalle->controlDeManto->cliente->telefono }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            Modelo: {{ $detalle->controlDeManto->modelo->codigo }}<br>
                                            Línea: {{ $detalle->controlDeManto->modelo->linea->nombre }}<br>
                                            Producto: {{ $detalle->controlDeManto->modelo->linea->producto->nombre }}
                                        </td>
                                        <td class="px-4 py-2 text-center">Plan: {{ $detalle->controlDeManto->planManto->nombre }}<br>
                                            Servicio No. {{ $detalle->controlDeManto->contador }}</td>
                                        <td class="px-4 py-2">
                                            <select name="estados[{{ $detalle->id_detalle_check }}]" class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                                @foreach($estados as $estado)
                                                    <option value="{{ $estado->id_estado }}" {{ $detalle->id_estado == $estado->id_estado ? 'selected' : '' }}>
                                                        {{ $estado->estado }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="date" name="fecha_manto[{{ $detalle->id_detalle_check }}]" value="{{ $detalle->fecha_manto }}" class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" id="observaciones" name="observaciones[{{ $detalle->id_detalle_check }}]" value="{{ $detalle->observaciones }}" class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600" placeholder="Aclaraciones">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <script>
                                document.getElementById('observaciones').addEventListener('input', function (e) {
                                    let inputValue = e.target.value;
                                    // Formatear la primera letra alfabética como mayúscula, incluyendo vocales con acento
                                    e.target.value = inputValue.replace(/^(.*?)([a-zA-ZÁÉÍÓÚáéíóú])/, function(_, prefix, firstLetter) {
                                        return prefix + firstLetter.toUpperCase();
                                    });
                                });
                            </script>
                            <div class="flex justify-center mt-4">
                                <x-primary-button type="submit">
                                    Guardar Cambios
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('checklist.index') }}">
                            <x-danger-button class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                                Finalizar
                            </x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
