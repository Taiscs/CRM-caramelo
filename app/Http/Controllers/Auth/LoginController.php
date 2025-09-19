<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Facade para autenticação
use Illuminate\Support\Facades\DB;   // Facade para interação com o banco de dados
use Illuminate\Support\Facades\Hash; // Facade para hash de senha
use App\Models\User; // Importa o modelo User
use App\Models\Usuario; // Importa o modelo Usuario (se você o criou)


class LoginController extends Controller
{
    /**
     * Exibe o formulário de login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Aponta para a view de login
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. Validação dos dados do formulário
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ], [
            'email.required' => 'O campo Usuário (e-mail) é obrigatório.',
            'email.email' => 'O Usuário deve ser um endereço de e-mail válido.',
            'senha.required' => 'O campo Senha é obrigatório.',
        ]);

        // 2. Tenta encontrar o usuário no banco de dados
        $user = DB::table('login')
                    ->join('usuarios', 'login.id_usuario', '=', 'usuarios.id')
                    ->where('login.login', $request->email)
                    ->select('login.*', 'usuarios.role')
                    ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Usuário não encontrado!'])->withInput($request->only('email'));
        }

        // 3. Verifica a senha
        if (Hash::check($request->senha, $user->senha)) {
            // Senha com hash (correta)
            $authUser = User::find($user->id_usuario);
            Auth::login($authUser);

        } elseif ($request->senha === $user->senha) {
            // Senha sem hash (precisa ser atualizada para hash)
            $hashedPassword = Hash::make($request->senha);
            DB::table('login')
                ->where('id_usuario', $user->id_usuario)
                ->update(['senha' => $hashedPassword]);

            $authUser = User::find($user->id_usuario);
            Auth::login($authUser);

        } else {
            // Senha incorreta
            return redirect()->back()->withErrors(['senha' => 'Senha incorreta!'])->withInput($request->only('email'));
        }

        // 4. Se o login foi bem-sucedido
        if (Auth::check()) {
            // Log de entrada
            DB::table('logs')->insert([
                'ID_USUARIO' => Auth::id(),
                'LOGIN' => $request->email,
                'ACAO' => 'Entrou no Sistema',
                'QUANDO' => now(),
            ]);

            // Redirecionamento por papel
            if (Auth::user()->role === 'admin') {
                return redirect()->route('homologacao');
            } else {
                return redirect()->route('chamados');
            }
        }

        // Se por algum motivo não autenticou (raro, mas para garantir)
        return redirect()->back()->withErrors(['geral' => 'Erro desconhecido no login.'])->withInput($request->only('email'));
    }

    // Método para logout (opcional, se você for usar)
    /*
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    */
}