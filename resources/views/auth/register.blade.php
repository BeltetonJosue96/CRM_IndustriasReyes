<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre y Apellido')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Datos del usuario" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <script>
            function formatInputToUpperCase(element) {
                element.addEventListener('input', function (e) {
                    let inputValue = e.target.value;
                    let formattedValue = inputValue.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
                    formattedValue = formattedValue.replace(/(?:^|\s)([a-záéíóúñ])/g, function (match, char) {
                        return match.replace(char, char.toUpperCase());
                    });

                    e.target.value = formattedValue;
                });
            }
            formatInputToUpperCase(document.getElementById('name'));
        </script>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo')" />

            <!-- Campo de texto donde el usuario solo ingresa el nick -->
            <x-text-input id="nick" class="block mt-1 w-full" type="text" name="nick" required placeholder="nombre para el correo" oninput="updateEmail()" />

            <!-- Campo oculto para enviar el correo real -->
            <input type="hidden" id="email" name="email" value="">

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <script>
            const domain = '@industriasreyes.net'; // El dominio fijo

            function updateEmail() {
                const nickInput = document.getElementById('nick');
                let cursorPosition = nickInput.selectionStart; // Guardamos la posición del cursor
                let nick = nickInput.value;

                // Si el valor ya contiene el dominio, eliminamos esa parte para que solo el nick sea editable
                if (nick.includes(domain)) {
                    nick = nick.split(domain)[0]; // Solo el nick sin el dominio
                }

                // Concatenamos el nick con el dominio
                nickInput.value = nick + domain;

                // Actualizar el valor del campo oculto con el email completo
                document.getElementById('email').value = nickInput.value;

                // Asegurar que el cursor permanezca en la parte del nick, sin ir más allá del '@'
                if (cursorPosition <= nick.length) {
                    nickInput.setSelectionRange(cursorPosition, cursorPosition); // Restauramos la posición original del cursor
                } else {
                    nickInput.setSelectionRange(nick.length, nick.length); // Si se intentaba mover después del dominio, lo fijamos al final del nick
                }
            }

            // Asegurar que el usuario no pueda borrar el dominio
            document.getElementById('nick').addEventListener('input', function (e) {
                let currentValue = e.target.value;

                if (!currentValue.includes(domain)) {
                    // Si el dominio ha sido eliminado accidentalmente, lo restauramos
                    currentValue = currentValue.split('@')[0]; // Tomamos el nick antes del dominio
                    e.target.value = currentValue + domain;
                }

                // Actualizamos el campo oculto
                document.getElementById('email').value = e.target.value;

                // Aseguramos que el cursor se mantenga en la parte editable (el nick)
                const nickLength = currentValue.split(domain)[0].length;
                e.target.setSelectionRange(nickLength, nickLength); // Fijar el cursor al final del nick
            });
        </script>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Contraseña segura"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirme la contraseña" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Volver al inicio') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
