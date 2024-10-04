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
                                <img src="https://cdn-icons-png.freepik.com/256/12019/12019654.png" alt="Modelos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Modelos
                                </span>
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
                            <a href="{{ route('lineas.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/12879/12879103.png" alt="Líneas" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Líneas
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('planes.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/4233/4233834.png" alt="Planes" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Planes de Mantenimiento
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('productos.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/2702/2702154.png" alt="Productos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Catálogo de Productos
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('estados.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/8558/8558628.png" alt="Estados" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Estados
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('departamentos.index') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/2060/2060593.png" alt="Departamentos" class="w-20 h-20 mb-2">
                                <span class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Departamentos de Guatemala
                                </span>
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <a href="{{ route('dashboard') }}" class="w-40 p-4 flex flex-col items-center justify-center bg-white dark:bg-gray-800">
                                <img src="https://cdn-icons-png.freepik.com/256/12208/12208421.png" alt="Regresar" class="w-20 h-20 mb-2">
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
