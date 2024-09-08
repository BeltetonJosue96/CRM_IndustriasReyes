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
                    <div class="text-center mt-6">
                        <a href="{{ route('productos.create') }}">
                            <x-primary-button class="ms-3">
                                {{ __('Agregar nuevo producto') }}
                            </x-primary-button>
                        </a>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <h3 class="justify-start text-xl text-gray-50 dark:text-gray-400">Lista de productos</h3>
                        <form action="{{ route('productos.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <x-primary-button class="ms-3">
                                Buscar/Limpiar
                            </x-primary-button>
                        </form>
                    </div>
                @if($productos->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">Sin coincidencias, no hay productos disponibles en este momento.</p>
                    @else
                        <div class="mt-6 relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
                            <table class="w-full table-auto min-w-max divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center md:text-sm text-gray-50 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-center md:text-sm text-gray-50 dark:text-gray-300 uppercase tracking-wider">Producto</th>
                                    <th scope="col" class="px-6 py-3 text-center md:text-sm text-gray-50 dark:text-gray-300 uppercase tracking-wider">Creación</th>
                                    <th scope="col" class="px-6 py-3 text-center md:text-sm text-gray-50 dark:text-gray-300 uppercase tracking-wider">Actualización</th>
                                    <th scope="col" class="px-6 py-3 text-center md:text-sm text-gray-50 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($productos as $producto)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 border-b border-blue-gray-50 whitespace-nowrap text-center md:text-sm text-gray-900 dark:text-white">PROD0{{ $producto->id_producto }}</td>
                                        <td class="px-6 border-b border-blue-gray-50 py-4 whitespace-nowrap md:text-sm text-gray-900 dark:text-white">{{ $producto->nombre }}</td>
                                        <td class="px-6 border-b border-blue-gray-50 py-4 whitespace-nowrap text-center md:text-sm text-gray-500 dark:text-gray-300">{{ $producto->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 border-b border-blue-gray-50 py-4 whitespace-nowrap text-center md:text-sm text-gray-500 dark:text-gray-300">{{ $producto->updated_at->format('d/m/Y') }}</td>
                                        <td class="px-6 border-b border-blue-gray-50 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-300">
                                            <div class="flex justify-center items-center">
                                                <a href="{{ route('productos.edit', $producto->id_producto) }}" class="py-2 px-4 rounded mr-2">
                                                    <x-primary-button>
                                                        {{ __('Modificar') }}
                                                    </x-primary-button>
                                                </a>
                                                <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button onclick="return confirm('¿Estás seguro de que quieres eliminar este {{ __('producto') }}?')">
                                                        {{ __('Eliminar') }}
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $productos->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
