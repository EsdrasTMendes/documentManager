<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Importação necessária para o Facade Log

class RegisteredUserController extends Controller
{
    /**
     * Exibe a view de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Lida com uma requisição de registro de usuário.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // A validação do Laravel já lida com exceções, redirecionando automaticamente com os erros.
        // Não é necessário um bloco try...catch para a validação.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Opcional: bloco try...catch para tratar erros inesperados após a validação.
        // Por exemplo, um erro no banco de dados.
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'user',
                'cpf' => $request->cpf,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));
            Auth::login($user);

            return redirect(route('dashboard'));
        } catch (\Exception $exception) {
            // Loga o erro para depuração
            Log::error("Erro inesperado no cadastro: " . $exception->getMessage());

            // Retorna o usuário para a página anterior com uma mensagem de erro genérica por segurança.
            return back()->withErrors(['message' => 'Ocorreu um erro inesperado. Por favor, tente novamente.']);
        }
    }
}
