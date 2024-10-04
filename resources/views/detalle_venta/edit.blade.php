<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle de Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('detalle_ventas.update', $detalle->hashed_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="costo" class="block text-sm font-medium text-gray-700">Costo (Q)</label>
                            <input type="text" name="costo" value="{{ $detalle->costo }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="id_modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                            <select name="id_modelo" class="mt-1 block w-full">
                                @foreach($modelos as $modelo)
                                    <option value="{{ $modelo->id }}" {{ $detalle->id_modelo == $modelo->id ? 'selected' : '' }}>
                                        {{ $modelo->codigo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="id_plan_manto" class="block text-sm font-medium text-gray-700">Plan de Mantenimiento</label>
                            <select name="id_plan_manto" class="mt-1 block w-full">
                                @foreach($planes as $plan)
                                    <option value="{{ $plan->id }}" {{ $detalle->id_plan_manto == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="py-2 px-4 rounded bg-blue-500 text-white hover:bg-blue-700">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
