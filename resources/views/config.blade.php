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
                    <a href="{{ route('productos.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                        <img src="https://cdn-icons-png.freepik.com/256/2702/2702154.png" alt="Productos" class="w-20 h-20 mr-2">
                        <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Catálogo de Productos
                        </span>
                    </a>
                    <a href="{{ route('planes.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                        <img src="https://cdn-icons-png.freepik.com/256/4233/4233834.png" alt="Planes" class="w-20 h-20 mr-2">
                        <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Planes de Mantenimiento
                        </span>
                    </a>
                    <a href="{{ route('empresas.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                        <img src="https://cdn-icons-png.freepik.com/256/6082/6082589.png" alt="Empresas" class="w-20 h-20 mr-2">
                        <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Empresas
                        </span>
                    </a>
                    <a href="{{ route('estados.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                        <img src="https://cdn-icons-png.freepik.com/256/8558/8558628.png" alt="Estados" class="w-20 h-20 mr-2">
                        <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Estados
                        </span>
                    </a>
                    <a href="{{ route('departamentos.index') }}" class="box-border h-40 w-40 p-4 border-4 flex flex-col items-center justify-center">
                        <img src="https://cdn-icons-png.freepik.com/256/2060/2060593.png" alt="Departamentos" class="w-20 h-20 mr-2">
                        <span class="text-center text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Departamentos de Guatemala
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
