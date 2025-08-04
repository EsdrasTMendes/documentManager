<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 space-y-6 transform transition-transform duration-300 ease-in-out hover:scale-105">
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-extrabold text-gray-900">Bem-vindo(a)</h1>
                <p class="mt-2 text-sm text-gray-600">Faça login para continuar</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" autocomplete="off" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="off" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full p-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm font-medium text-gray-700">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember"
                            autocomplete="off">
                        <span class="ms-2">{{ __("Lembrar de mim") }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-900 font-medium hover:underline transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                            {{ __('Esqueci minha senha') }}
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-center">
                    <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        {{ __('Entrar') }}
                    </x-primary-button>
                </div>

                <div class="flex items-center justify-center">
                    <a class="w-full text-center text-sm text-gray-600 hover:text-gray-900 hover:underline font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out" href="{{ route('register') }}">
                        {{ __('Não tem conta? Cadastre-se') }}
                    </a>
                </div>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const emailInput = document.getElementById('email');
                    const rememberCheckbox = document.getElementById('remember_me');
                    const savedEmail = localStorage.getItem('savedEmail');
                    if (savedEmail) {
                        emailInput.value = savedEmail;
                        rememberCheckbox.checked = true;
                    }

                    const form = emailInput.closest('form');
                    form.addEventListener('submit', () => {
                        if (rememberCheckbox.checked) {
                            localStorage.setItem('savedEmail', emailInput.value);
                        } else {
                            localStorage.removeItem('savedEmail');
                        }
                    });
                });
            </script>
        </div>
    </div>
</x-guest-layout>
