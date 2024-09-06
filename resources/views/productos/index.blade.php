<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($productos->isEmpty())
                        <p class="text-center text-gray-500">No hay productos disponibles en este momento.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Producto</th>
                                    <th class="py-2 px-4 border-b">Fecha de Creación</th>
                                    <th class="py-2 px-4 border-b">Última Actualización</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($productos as $producto)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b">{{ $producto->id_producto }}</td>
                                        <td class="py-2 px-4 border-b">{{ $producto->nombre }}</td>
                                        <td class="py-2 px-4 border-b">{{ $producto->created_at->format('d/m/Y') }}</td>
                                        <td class="py-2 px-4 border-b">{{ $producto->updated_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Botón para agregar un nuevo producto --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('productos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Agregar Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
