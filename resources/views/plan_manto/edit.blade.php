<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planes de Mantenimiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">{{ __('Editar Plan de Mantenimiento') }}</h2>
                    @if ($errors->any())
                        <div id="error-messages" class="text-black dark:text-gray-200 rounded-lg p-4 mb-4">
                            <ul class="text-center">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xl font-bold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <script>
                        setTimeout(function() {
                            var errorMessages = document.getElementById('error-messages');
                            if (errorMessages) {
                                errorMessages.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <form action="{{ route('planes.update', $planes->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="id_plan_manto" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ID Seguro') }}</label>
                            <input type="text" name="id_plan_manto" id="id_plan_manto" value="{{ $planes->hashed_id }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="nombre" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300 mt-6">{{ __('Nombre') }}</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $planes->nombre) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="descripcion" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300 mt-6">{{ __('Descripción') }}</label>
                            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $planes->descripcion) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="frecuencia_mes" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300 mt-6">{{ __('Frecuencia') }}</label>
                            <input type="number" name="frecuencia_mes" id="frecuencia_mes" value="{{ old('frecuencia_mes', $planes->frecuencia_mes) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex justify-center">
                            <x-primary-button>
                                {{ __('Modificar') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <div class="flex justify-center mt-6">
                        <a href="{{ route('planes.index') }}">
                            <x-danger-button>
                                {{ __('Cancelar') }}
                            </x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
