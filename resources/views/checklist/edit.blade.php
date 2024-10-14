<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checklist Posventa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200">Edición de Cebecera</h2>
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">Checklist No. {{ $check->id_check }} - {{ \Carbon\Carbon::parse($check->fecha_creacion)->year }}</h2>
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
                    @if (session('success'))
                        <div class="px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('checklist.update', $check->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="flex items-center">
                                <label for="id_check" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">ID Seguro</label>
                                <input type="text" name="id_check" id="id_check" value="{{ $check->hashed_id }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" readonly>
                            </div>
                            <div class="flex items-center">
                                <label for="fecha_creacion" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Fecha de Creación</label>
                                <input type="date" name="fecha_creacion" id="fecha_creacion" value="{{ old('fecha_creacion', $check->fecha_creacion) }}" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                            </div>
                            <div class="flex items-center">
                                <label for="id_plan_manto" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Plan de Mantenimiento</label>
                                <select name="id_plan_manto" id="id_plan_manto" class="form-control w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                    <option value="" disabled selected>Seleccione un Plan de Mantenimiento</option>
                                    @foreach($planes as $plan)
                                        <option value="{{ $plan->id_plan_manto}}" {{ $plan->id_plan_manto == $check->id_plan_manto ? 'selected' : '' }}>
                                            {{ $plan->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-center space-x-4 mt-6">
                            <x-primary-button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                                Actualizar
                            </x-primary-button>
                        </div>
                    </form>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('checklist.index') }}">
                            <x-danger-button class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                                Cancelar
                            </x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
