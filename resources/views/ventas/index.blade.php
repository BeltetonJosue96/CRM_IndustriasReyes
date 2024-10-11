<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Comienza el contenido -->
                    <div class="text-center">
                        <a href="{{ route('ventas.create') }}">
                            <x-primary-button class="ms-3">
                                🔴 {{ __('Agregar nueva venta') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('clientes.index') }}">
                            <x-primary-button class="ms-3">
                                {{ __('Ir a clientes') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('modelos.index') }}">
                            <x-primary-button class="ms-3">
                                {{ __('Ir a modelos') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('dashboard') }}">
                            <x-danger-button class="ms-3">
                                {{ __('Regresar') }}
                            </x-danger-button>
                        </a>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">Ventas registradas</h2>
                    </div>
                    <!-- Cuadro de búsqueda centrado -->
                    <div class="flex flex-col items-center mt-2">
                        <form action="{{ route('ventas.index') }}" method="GET" class="flex items-center space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar ventas..." class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <x-primary-button class="ms-1">
                                🔍
                            </x-primary-button>
                        </form>
                    </div>
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

                    @if($ventas->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400 mt-4">Sin coincidencias, no hay ventas disponibles en este momento.</p>
                    @else
                        <table class="mt-6 w-full table-auto items-center">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">No.</th>
                                <th class="px-4 py-2">Fecha</th>
                                <th class="px-4 py-2">Descripción</th>
                                <th class="px-4 py-2">Cliente</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($ventas as $venta)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-center">{{ $venta->id_venta }} - {{ \Carbon\Carbon::parse($venta->fecha_venta)->year }}</td>
                                    <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-center">{{ $venta->descripcion }}</td>
                                    <td class="px-4 py-2 text-center">{{ $venta->id_cliente + 1000}}-{{ \Carbon\Carbon::parse($venta->created_at)->year }}<br>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('detalle_ventas.edit', $venta->hashed_id ) }}" class="py-2 px-4 rounded bg-blue-500 text-white hover:bg-blue-700">
                                                🧾
                                            </a>
                                            <a href="{{ route('ventas.edit', $venta->hashed_id ) }}" class="py-2 px-4 rounded bg-blue-500 text-white hover:bg-blue-700">
                                                ✍️
                                            </a>
                                            <form action="{{ route('ventas.destroy', $venta->hashed_id ) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¡Atención! ⚠️ Al eliminar esta venta, TODOS los registros de detalles y mantenimientos asociados quedarán automáticamente eliminados. ❌ Esta acción NO puede deshacerse. ¡Piénsalo bien antes de continuar!')" class="py-2 px-4 rounded bg-red-500 text-white hover:bg-red-700">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $ventas->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
