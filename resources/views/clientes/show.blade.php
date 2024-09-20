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
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Detalles del Cliente</h2>
                    <div class="mt-4">
                        <p><strong>Nombre: </strong>{{ $cliente->nombre }}</p>
                        <p><strong>Apellidos: </strong>{{ $cliente->apellidos }}</p>
                        <p><strong>Identificación: </strong>{{ $cliente->identificacion }}</p>
                        <p><strong>Teléfono: </strong>{{ $cliente->telefono }}</p>
                        <p><strong>Dirección: </strong>{{ $cliente->direccion }}</p>
                        <p><strong>Referencia: </strong>{{ $cliente->referencia }}</p>
                        <p><strong>Municipio: </strong>{{ $cliente->municipio }}</p>
                        <p><strong>Departamento: </strong>{{ $cliente->departamento->nombre }}</p>
                        <p><strong>Empresa: </strong>{{ $cliente->empresa ? $cliente->empresa->nombre : 'Sin empresa' }}</p>
                        <p><strong>Cargo: </strong>{{ $cliente->cargo ? : 'Persona individual' }}</p>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <!-- Botón de regresar -->
                        <a href="{{ route('clientes.index') }}" >
                            <x-primary-button class="ms-3">
                                {{ __('Regresar') }}
                            </x-primary-button>
                        </a>

                        <!-- Botón de modificar -->
                        <a href="{{ route('clientes.edit', $cliente->hashed_id ) }}" >
                            <x-primary-button class="ms-3">
                                {{ __('Modificar') }}
                            </x-primary-button>
                        </a>

                        <!-- Botón de eliminar -->
                        <form action="{{ route('clientes.destroy', $cliente->hashed_id ) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">
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
