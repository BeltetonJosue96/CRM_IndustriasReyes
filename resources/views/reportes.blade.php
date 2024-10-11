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
                    <!-- Formulario de Filtros -->
                    <form method="GET" action="{{ route('reportes') }}" class="mb-6">
                        <div class="flex flex-wrap -mx-2">
                            <!-- Filtro por Cliente -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="id_cliente" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cliente</label>
                                <select name="id_cliente" id="id_cliente" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccione el cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id_cliente }}" {{ ($id_cliente == $cliente->id_cliente) ? 'selected' : '' }}>
                                            ID: {{ $cliente->id_cliente + 1000 }}-{{ \Carbon\Carbon::parse($cliente->created_at)->year }}<br>
                                            {{ $cliente->nombre }} {{ $cliente->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por Empresa -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="id_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empresa</label>
                                <select name="id_empresa" id="id_empresa" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Todas las empresas</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}" {{ ($id_empresa == $empresa->id_empresa) ? 'selected' : '' }}>
                                            {{ $empresa->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por Fecha de Inicio -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $fecha_inicio }}" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Filtro por Fecha de Fin -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $fecha_fin }}" class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Filtrar
                            </button>
                            <a href="{{ route('reportes.exportar_pdf', request()->all()) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Exportar a PDF
                            </a>
                        </div>
                    </form>

                    <!-- Tabla de Ventas Detalladas -->
                    @if($detalles->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Modelo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Plan Manto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Costo (Q)</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $iterator = ($detalles->currentPage() - 1) * $detalles->perPage() + 1;
                                @endphp
                                @foreach($detalles as $detalle)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $iterator++ }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $detalle->id_modelo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $detalle->id_plan_manto }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($detalle->costo, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right font-semibold">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ number_format($total, 2) }} Q</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $detalles->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">No se encontraron ventas con los filtros aplicados.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
