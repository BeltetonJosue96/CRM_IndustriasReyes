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
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                        Bienvenido(a) {{ Auth::user()->name }}
                    </h1>
                    <div class="grid grid-cols-2 gap-4 mt-6 place-items-center">
                        <div class="w-full flex justify-center">
                            <a href="{{ route('clientes.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/2194/2194222.png" alt="Clientes" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">Clientes</span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('empresas.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/6082/6082589.png" alt="Empresas" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Empresas
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('ventas.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/781/781760.png" alt="Ventas" class="w-20 h-20 mr-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">Ventas</span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('checklist.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/2666/2666436.png" alt="Checklist" class="w-20 h-20 mr-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">Checklist Posventa</span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('historial.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/2936/2936725.png" alt="Reportes" class="w-20 h-20 mr-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">Reportes</span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('config') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/3315/3315581.png" alt="Configuracion" class="w-20 h-20 mr-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">Configuraciones</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
