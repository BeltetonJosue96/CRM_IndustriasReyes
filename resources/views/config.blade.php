<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuraciones del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                        Opciones de configuración
                    </h1>
                    <div class="grid grid-cols-2 gap-4 mt-6 place-items-center">
                        <div class="w-full flex justify-center">
                            <a href="{{ route('modelos.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/modelos.png') }}" alt="Modelos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Modelos
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('estados.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/estados.png') }}" alt="Estados" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Estados
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('lineas.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/lineas.png') }}" alt="Líneas" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Líneas
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('planes.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/planesmanto.png') }}" alt="Planes" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Planes de Mantenimiento
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('productos.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/productos.png') }}" alt="Productos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Productos
                                </span>
                            </a>
                        </div>

                        <div class="w-full flex justify-center">
                            <a href="{{ route('departamentos.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/departamentos.png') }}" alt="Departamentos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Departamentos de Guatemala
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">

                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('dashboard') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="{{ asset('images/regresar.png') }}" alt="Regresar" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Regresar
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
