<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 p-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8 space-y-6 transform transition-transform duration-300 ease-in-out hover:scale-105">
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-extrabold text-gray-900">Cadastre-se</h1>
                <p class="mt-2 text-sm text-gray-600">Crie sua conta para começar</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p class="font-bold">Ops! Algo deu errado.</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input id="email" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="phone_number" :value="__('Telefone')" />
                        <x-text-input id="phone_number" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" type="tel" name="phone_number" :value="old('phone_number')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="cpf" :value="__('CPF')" />
                        <x-text-input id="cpf" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" type="tel" name="cpf" :value="old('cpf')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input id="password" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirme sua senha')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center">
                    <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        {{ __('Cadastre-se') }}
                    </x-primary-button>
                </div>

                <div class="flex items-center justify-center">
                    <a class="w-full text-center text-sm text-gray-600 hover:text-gray-900 hover:underline font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out" href="{{ route('login') }}">
                        {{ __('Já possui cadastro?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const phoneInput = document.getElementById('phone_number');
            const cpfInput = document.getElementById('cpf');

            // Máscara para Telefone (99) 99999-9999
            function maskPhone(value) {
                if (!value) return "";
                value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
                value = value.replace(/^(\d{2})(\d)/g, "($1) $2"); // Coloca parênteses em volta dos dois primeiros dígitos
                value = value.replace(/(\d)(\d{4})$/, "$1-$2"); // Coloca o hífen entre o quinto e o sexto dígito
                return value;
            }

            // Máscara para CPF 999.999.999-99
            function maskCPF(value) {
                if (!value) return "";
                value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
                value = value.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o primeiro ponto
                value = value.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o segundo ponto
                value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca o hífen
                return value;
            }

            phoneInput.addEventListener('input', (e) => {
                e.target.value = maskPhone(e.target.value);
            });

            cpfInput.addEventListener('input', (e) => {
                e.target.value = maskCPF(e.target.value);
            });
        });
    </script>
</x-guest-layout>
