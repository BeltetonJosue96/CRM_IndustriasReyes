<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control de Mantenimientos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-center space-x-2 mt-4">
                        <a href="{{ route('reportes') }}" class="ms-3">
                            <x-danger-button>
                                {{ __('Regresar') }}
                            </x-danger-button>
                        </a>
                    </div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-8 mb-8 text-center">Registro del Control de Mantenimientos</h2>
                    <div class="flex flex-col items-center mt-2">
                        <form action="{{ route('controlmantos.index') }}" method="GET" class="flex items-center space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar en el control..." class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <x-primary-button class="ms-1">
                                🔍
                            </x-primary-button>
                        </form>
                    </div>
                    <table class="mt-6 w-full table-auto items-center mt-4">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Cliente</th>
                            <th class="px-4 py-2">Modelo</th>
                            <th class="px-4 py-2">Plan Mantenimiento</th>
                            <th class="px-4 py-2">Fecha Venta</th>
                            <th class="px-4 py-2">Próximo Mantenimiento</th>
                            <th class="px-4 py-2">Contador de Servicios</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($controlMantos as $controlManto)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 text-center">{{ $controlManto->id_control_manto }}</td>
                                <td class="px-4 py-2">{{ $controlManto->nombre_cliente }} {{ $controlManto->apellidos_cliente }}</td>
                                <td class="px-4 py-2 text-center">{{ $controlManto->nombre_modelo }}</td>
                                <td class="px-4 py-2 text-center">{{ $controlManto->nombre_plan }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if (is_null($controlManto->fecha_venta) || \Carbon\Carbon::parse($controlManto->fecha_venta)->isToday())
                                        Campo Nulo
                                    @else
                                        {{ \Carbon\Carbon::parse($controlManto->fecha_venta)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if (is_null($controlManto->proximo_manto) || \Carbon\Carbon::parse($controlManto->proximo_manto)->isToday())
                                        Campo Nulo
                                    @else
                                        {{ \Carbon\Carbon::parse($controlManto->proximo_manto)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">{{ $controlManto->contador }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $controlMantos->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
