<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial de Mantenimientos') }}
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
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-8 mb-8 text-center">Registro del Historial de Mantenimientos</h2>
                    <div class="flex flex-col items-center mt-2">
                        <form action="{{ route('historial.index') }}" method="GET" class="flex items-center space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar en historial..." class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <x-primary-button class="ms-1">
                                🔍
                            </x-primary-button>
                        </form>
                    </div>
                    <table class="mt-6 w-full table-auto items-center">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">ID Detalle Check</th>
                            <th class="px-4 py-2">ID Control Manto</th>
                            <th class="px-4 py-2">ID Estado</th>
                            <th class="px-4 py-2">Fecha Programada</th>
                            <th class="px-4 py-2">Contador</th>
                            <th class="px-4 py-2">Observaciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($historiales as $historial)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 text-center">{{ $historial->id_historial_manto }}</td>
                                <td class="px-4 py-2 text-center">{{ $historial->id_detalle_check }}</td>
                                <td class="px-4 py-2 text-center">{{ $historial->id_control_manto }}</td>
                                <td class="px-4 py-2">{{ $historial->nombre_estado }}</td>
                                <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($historial->fecha_programada)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-center">{{ $historial->contador }}</td>
                                <td class="px-4 py-2">{{ $historial->observaciones }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $historiales->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

