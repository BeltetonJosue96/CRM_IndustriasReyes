<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reportes de Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-8 mb-8 text-center">Visualización de registros del sistema</h2>
                    <div class="flex justify-center space-x-2 mt-4">
                        <a href="{{ route('historial.index') }}" class="ms-3">
                            <x-primary-button >
                            {{ __('📖 Historial de Mantenimientos') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('controlmantos.index') }}" class="ms-3">
                            <x-primary-button >
                            {{ __('⚙️ Control de Mantenimiento') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('checklist.index') }}" class="ms-3">
                            <x-primary-button >
                                {{ __('Ir a Checklist') }}
                            </x-primary-button>
                        </a>
                        <a href="{{ route('dashboard') }}" class="ms-3">
                            <x-danger-button>
                                {{ __('Regresar') }}
                            </x-danger-button>
                        </a>
                    </div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6 mb-6 text-center">Parámetros del reporte</h2>
                    <form method="GET" action="{{ route('reportes') }}" class="mb-6">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="id_cliente" class="block text-md font-medium text-gray-700 dark:text-gray-300">Cliente</label>
                                <select name="id_cliente" id="id_cliente" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Todos los clientes</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id_cliente }}" {{ ($id_cliente == $cliente->id_cliente) ? 'selected' : '' }}>
                                            ID: {{ $cliente->id_cliente + 1000 }}-{{ \Carbon\Carbon::parse($cliente->created_at)->year }}<br>
                                            {{ $cliente->nombre }} {{ $cliente->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="id_empresa" class="block text-md font-medium text-gray-700 dark:text-gray-300">Empresa</label>
                                <select name="id_empresa" id="id_empresa" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Todas las empresas</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}" {{ ($id_empresa == $empresa->id_empresa) ? 'selected' : '' }}>
                                            {{ $empresa->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="fecha_inicio" class="block text-md font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $fecha_inicio }}" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="fecha_fin" class="block text-md font-medium text-gray-700 dark:text-gray-300">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $fecha_fin }}" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                        <div class="flex justify-center space-x-2 mt-4">
                            <x-primary-button type="submit" class="ms-3">
                                🔴 Generar reporte
                            </x-primary-button>
                        </div>
                    </form>
                    <div class="flex justify-center space-x-2 mt-4">
                        <a href="{{ route('reportes.exportar_pdf', request()->all()) }}" class="ms-3">
                            <x-primary-button>
                                🖨️ Exportar a PDF
                            </x-primary-button>
                        </a>
                    </div>

                    @if($detalles->count())
                        <div class="overflow-x-auto">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-8 mb-8 text-center">Previsualización de datos</h2>
                            <table class="mt-6 w-full table-auto items-center">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Cliente</th>
                                    <th class="px-4 py-2">Fecha de Venta</th>
                                    <th class="px-4 py-2">No. Venta</th>
                                    <th class="px-4 py-2">Bien o Servicio</th>
                                    <th class="px-4 py-2">Plan de<br>Mantenimiento</th>
                                    <th class="px-4 py-2">Costo (Q)</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $iterator = ($detalles->currentPage() - 1) * $detalles->perPage() + 1;
                                @endphp
                                @foreach($detalles as $detalle)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-2 text-center">{{ $iterator++ }}</td>
                                        <td class="px-4 py-2 text-left">
                                            {{ $detalle->venta->cliente->nombre }}<br>
                                            {{ $detalle->venta->cliente->apellidos }}
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($detalle->venta->fecha_venta)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 text-center">{{ $detalle->id_venta }} - {{ $detalle->venta->created_at->format('Y') }}</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ $detalle->modelo->codigo }}<br>
                                            {{ $detalle->modelo->linea->nombre }}<br>
                                            {{ $detalle->modelo->linea->producto->nombre }}
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ $detalle->planManto->nombre }}</td>
                                        <td class="px-4 py-2 text-center">{{ number_format($detalle->costo, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-md text-gray-900 dark:text-gray-100 text-right font-semibold">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-md text-gray-900 dark:text-gray-100 font-semibold">Q {{ number_format($total, 2) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="mt-4">
                                {{ $detalles->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 mt-4">No se encontraron registros con los parámetros aplicados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
