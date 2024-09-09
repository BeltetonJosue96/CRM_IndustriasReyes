<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Comienza el contenido -->
                        <div class="text-center">
                            <a href="{{ route('estados.create') }}">
                                <x-primary-button class="ms-3">
                                    {{ __('Agregar nuevo estado') }}
                                </x-primary-button>
                            </a>
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">Productos registrados</h2>
                        </div>
                        <!-- Cuadro de búsqueda centrado -->
                        <div class="flex flex-col items-center mt-2">
                            <form action="{{ route('estados.index') }}" method="GET" class="flex items-center space-x-2">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar estados..." class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <x-primary-button class="ms-1">
                                    🔍
                                </x-primary-button>
                            </form>
                        </div>

                        @if($estados->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">Sin coincidencias, no hay estados disponibles en este momento.</p>
                        @else
                            <table class="mt-6 w-full table-auto items-center">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($estados as $estado)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-2">{{ $estado->estado }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('estados.edit', $estado->hashed_id ) }}" class="py-2 px-4 rounded bg-blue-500 text-white hover:bg-blue-700">
                                                    ✍️
                                                </a>
                                                <form action="{{ route('estados.destroy', $estado->hashed_id ) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este estado?')" class="py-2 px-4 rounded bg-red-500 text-white hover:bg-red-700">
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
                            {{ $estados->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
