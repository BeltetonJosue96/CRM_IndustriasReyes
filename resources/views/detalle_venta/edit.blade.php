<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Detalle de Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200">
                        Edición del Detalle
                    </h2>
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">
                        Venta No. {{ $venta->id_venta }} - {{ \Carbon\Carbon::parse($venta->fecha_venta)->year }}
                    </h2>
                    @if ($errors->any())
                        <div id="error-messages" class="text-black dark:text-gray-200 rounded-lg p-4 mb-4">
                            <ul class="text-center">
                                @foreach ($errors->all() as $error)
                                    <li class="text-xl font-bold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @foreach($detalles as $detalle)
                        <form id="detalleVentaForm-{{ $detalle->id_detalle }}" action="{{ route('detalle_ventas.update', $hashids->encode($detalle->id_detalle)) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="hashed_id_venta" value="{{ $hashedId }}">
                            <div class="grid grid-cols-1 gap-4 mb-6">
                                <div class="flex items-center">
                                    <label for="id_modelo" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Modelo</label>
                                    <select name="id_modelo" id="id_modelo" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                        <option value="" disabled>Seleccione un modelo</option>
                                        @foreach($modelos as $modelo)
                                            <option value="{{ $modelo->id_modelo }}" {{ $modelo->id_modelo == $detalle->id_modelo ? 'selected' : '' }}>
                                                {{ $modelo->modelo_codigo }} - {{ $modelo->descripcion }} - Línea: {{ $modelo->linea_nombre }} - Producto: {{ $modelo->producto_nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center">
                                    <label for="costo" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Costo(Q)</label>
                                    <input type="number" step="0.01" name="costo" id="costo" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{ $detalle->costo }}" required oninput="validatePrecio(this)">
                                </div>
                                <script>
                                    function validatePrecio(input) {
                                        // Permitir solo números y un solo punto
                                        input.value = input.value.replace(/[^0-9.]/g, '');  // Permitir números y puntos
                                        // Verificar si ya hay más de un punto
                                        let parts = input.value.split('.');
                                        if (parts.length > 2) {
                                            input.value = parts[0] + '.' + parts[1];  // Si hay más de un punto, se permite solo el primero
                                        }
                                        // Limitar los decimales a dos cifras después del punto
                                        if (parts.length === 2 && parts[1].length > 2) {
                                            input.value = parts[0] + '.' + parts[1].substring(0, 2);
                                        }
                                    }
                                </script>
                                <div class="flex items-center">
                                    <label for="id_plan_manto" class="block text-lg font-medium text-gray-700 dark:text-gray-300 pr-4">Plan de Mantenimiento</label>
                                    <select name="id_plan_manto" id="id_plan_manto" class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" required>
                                        <option value="" disabled>Seleccione un plan de mantenimiento</option>
                                        @foreach($planes as $plan)
                                            <option value="{{ $plan->id_plan_manto }}" {{ $plan->id_plan_manto == $detalle->id_plan_manto ? 'selected' : '' }}>
                                                {{ $plan->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-center space-x-4 mt-6">
                                <x-primary-button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                                    Modificar
                                </x-primary-button>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl text-center font-semibold text-gray-800 dark:text-gray-200 mb-6">
                        Total de la Venta No. {{ $venta->id_venta }} - {{ \Carbon\Carbon::parse($venta->fecha_venta)->year }}
                    </h2>
                    <div class="mt-6">
                        <table id="detallesVentaTable" class="mt-6 w-full table-auto items-center">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Correlativo</th>
                                <th class="px-4 py-2">Modelo</th>
                                <th class="px-4 py-2">Costo (Q)</th>
                                <th class="px-4 py-2">Plan de Mantenimiento</th>
                                <th class="px-4 py-2">Opción</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($detalles as $index => $detalle)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 text-center">{{ $detalle->id_detalle }}</td>
                                    <td class="px-4 py-2 text-center">{{ $detalle->modelo->codigo }}</td>
                                    <td class="px-4 py-2 text-center">{{ $detalle->costo }}</td>
                                    <td class="px-4 py-2 text-center">{{ $detalle->planManto->nombre }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <form action="{{ route('detalle_ventas.destroy', $detalle->hashed_id ) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¡Atención! ⚠️ Al eliminar este registro, EL mantenimiento asociado quedarán automáticamente eliminado. ❌ Esta acción NO puede deshacerse. ¡Piénsalo bien antes de continuar!')" class="py-2 px-4 rounded bg-red-500 text-white hover:bg-red-700">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="py-4 font-bold text-center">
                                    Total: <span id="totalCost">Q {{ $detalles->sum('costo') }}</span>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('ventas.index') }}">
                            <x-danger-button class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                                Finalizar
                            </x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemCounter = {{ count($detalles) }};
        let totalCost = {{ $detalles->sum('costo') }};

        // Manejo del envío del formulario para agregar un nuevo detalle
        document.getElementById('detalleVentaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const loadingIndicator = document.getElementById('loading');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            fetch('{{ route('detalle_ventas.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }

                    if (data.success) {
                        // Limpiar los campos del formulario
                        this.reset();

                        // Agregar el nuevo detalle a la tabla
                        const detallesTable = document.getElementById('detallesVentaTable').getElementsByTagName('tbody')[0];
                        itemCounter++;

                        const newRow = detallesTable.insertRow();
                        newRow.setAttribute('data-id', data.detalle.hashed_id); // Agregar el hashed_id como atributo para identificar la fila
                        newRow.innerHTML = `
                    <td class="px-4 py-2 text-center">${itemCounter}</td>
                    <td class="px-4 py-2 text-center">${data.detalle.id_detalle}</td>
                    <td class="px-4 py-2 text-center">${data.detalle.modelo.descripcion}</td>
                    <td class="px-4 py-2 text-center">${data.detalle.costo}</td>
                    <td class="px-4 py-2 text-center">${data.detalle.plan_manto}</td>
                    <td class="px-4 py-2 text-center">
                            <form class="deleteForm" data-id="${data.detalle.hashed_id}" action="/detalle_ventas/${data.detalle.hashed_id}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    `;

                        totalCost += parseFloat(data.detalle.costo);
                        document.getElementById('totalCost').innerText = `Q ${totalCost.toFixed(2)}`;
                    } else if (data.errors) {
                        alert('Se encontraron errores. Por favor, revise los campos del formulario.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + (error.response?.data?.message || 'Ha ocurrido un error al procesar la solicitud.'));
                });
        });

        // Manejo del envío del formulario para eliminar un detalle
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('deleteForm')) {
                e.preventDefault();

                // Mostrar mensaje de confirmación personalizado
                const confirmDelete = confirm('¡Atención! ⚠️ Al eliminar este registro, EL mantenimiento asociado quedará automáticamente eliminado. ❌ Esta acción NO puede deshacerse. ¡Piénsalo bien antes de continuar!');

                if (!confirmDelete) {
                    return; // Si el usuario cancela, no continúa con la eliminación
                }

                const form = e.target;
                const hashedId = form.getAttribute('data-id');
                const url = form.getAttribute('action');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar la fila de la tabla
                            const rowToDelete = document.querySelector(`tr[data-id="${hashedId}"]`);
                            if (rowToDelete) {
                                rowToDelete.remove();
                            }

                            // Restar el costo eliminado del total
                            totalCost -= parseFloat(data.costo_eliminado);
                            document.getElementById('totalCost').innerText = `Q ${totalCost.toFixed(2)}`;
                        } else {
                            alert('No se pudo eliminar el detalle.');
                        }
                    })
                    .catch(error => {
                        console.error('Error al eliminar el detalle:', error);
                        alert('Error: ' + (error.response?.data?.message || 'Ha ocurrido un error al eliminar el detalle.'));
                    });
            }
        });
    </script>

</x-app-layout>
