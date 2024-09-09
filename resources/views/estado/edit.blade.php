<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Estados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mx-auto mt-8 bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white text-center">{{ __('Editar Estado') }}</h3>
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
                        <form action="{{ route('estados.update', $estado->hashed_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="id_estado" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ID Seguro') }}</label>
                                <input type="text" name="id_estado" id="id_estado" value="{{ $estado->hashed_id }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="estado" class="block md:text-sm font-medium text-gray-700 dark:text-gray-300 mt-6">{{ __('Nombre del Estado') }}</label>
                                <input type="text" name="estado" id="estado" value="{{ old('estado', $estado->estado) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex justify-center">
                                <x-primary-button>
                                    {{ __('Modificar') }}
                                </x-primary-button>
                            </div>
                        </form>

                        <div class="flex justify-center mt-6">
                            <a href="{{ route('estados.index') }}">
                                <x-danger-button>
                                    {{ __('Cancelar') }}
                                </x-danger-button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
