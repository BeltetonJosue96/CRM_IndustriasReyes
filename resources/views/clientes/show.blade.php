<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-2xl mx-auto bg-gray-100 dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                        <div class="px-6 py-5 sm:px-8">
                            <h3 class="text-xl text-center leading-6 font-bold text-gray-900 dark:text-white">Información del Cliente</h3>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700">
                            <dl>
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">ID de Cliente</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->id_cliente + 1000 }}-{{ \Carbon\Carbon::parse($cliente->created_at)->year }}</dd>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Nombre Completo</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->nombre }} {{ $cliente->apellidos }}</dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Identificación</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->identificacion }}</dd>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Teléfono</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->telefono }}</dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Dirección</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->direccion }}</dd>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Referencia</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->referencia }}</dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Municipio</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->municipio }}</dd>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Departamento</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->departamento->nombre }}</dd>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Empresa</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->empresa ? $cliente->empresa->nombre : 'Sin empresa' }}</dd>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                                    <dt class="text-base font-medium text-gray-600 dark:text-gray-300">Cargo</dt>
                                    <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $cliente->cargo ?: 'Persona individual' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <!-- Botón de modificar -->
                        <a href="{{ route('clientes.edit', $cliente->hashed_id ) }}" >
                            <x-primary-button class="ms-3">
                                {{ __('Modificar') }}
                            </x-primary-button>
                        </a>
                        <!-- Botón de regresar -->
                        <a href="{{ route('clientes.index') }}" >
                            <x-primary-button class="ms-3">
                                {{ __('🔴 Regresar') }}
                            </x-primary-button>
                        </a>
                        <!-- Botón de eliminar -->
                        <form action="{{ route('clientes.destroy', $cliente->hashed_id ) }}" method="POST" onsubmit="return confirm('¡Atención! ⚠️ Al eliminar este cliente, TODAS las dependencias quedarán automáticamente eliminadas. ❌ Esta acción NO puede deshacerse. ¡Piénsalo bien antes de continuar!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <x-danger-button class="ms-3">
                                    {{ __('Eliminar') }}
                                </x-danger-button>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
