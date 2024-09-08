<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Escritorio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                        Bienvenido(a)
                    </h3>
                    <div class="grid grid-cols-2 gap-8 mt-6">
                        <a href="{{ route('clientes.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/2194/2194222.png" alt="Clientes" class="w-20 h-20 mb-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">Clientes</span>
                        </a>
                        <a href="{{ route('checklist.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/2666/2666436.png" alt="Checklist" class="w-20 h-20 mr-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Checklist Posventa
                            </span>
                        </a>
                        <a href="{{ route('ventas.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/781/781760.png" alt="Checklist" class="w-20 h-20 mr-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Ventas
                            </span>
                        </a>
                        <a href="{{ route('historial.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/2936/2936725.png" alt="Checklist" class="w-20 h-20 mr-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Reportes
                            </span>
                        </a>
                        <a href="{{ route('productos.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/2702/2702154.png" alt="Productos" class="w-20 h-20 mr-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Catálogo de Productos
                            </span>
                        </a>
                        <a href="{{ route('planes.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                            <img src="https://cdn-icons-png.freepik.com/256/4233/4233834.png" alt="Productos" class="w-20 h-20 mr-2">
                            <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Planes de Mantenimiento
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
