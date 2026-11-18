<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    /*
     * Q2 – Login
     *
     * 1. Importe a facade: use Illuminate\Support\Facades\Auth;
     * 2. Pegue só os dois campos do formulário:
     *    $credenciais = $request->only('email', 'password');
     *    (ou valide com $request->validate([...]), que já devolve o array)
     * 3. Auth::attempt($credenciais) devolve true ou false. Ele já compara
     *    a senha com o hash do banco: não faça Hash::check na mão.
     * 4. Se der false, volte ao login com erro:
     *    return back()->withErrors(['email' => 'E-mail ou senha inválidos.']);
     *    - a view mostra os erros do campo "email"
     *    - ->onlyInput('email') mantém o e-mail digitado
     * 5. Se der true:
     *    $request->session()->regenerate();   // boa prática de segurança
     *    return redirect()->intended(route('eventos.index'));
     *    - intended() leva para a página que a pessoa tentou abrir antes
     *      de cair no login; se não houver, usa a rota informada
     */
    public function attempt(Request $request)
    {
        //
    }

    /*
     * Q2 – Logout
     *
     * 1. Auth::logout();
     * 2. $request->session()->invalidate();
     * 3. $request->session()->regenerateToken();
     * 4. Redirecione para alguma página pública (ex.: route('eventos.index'))
     *
     * A rota é POST: o botão "Sair" do layout já envia um formulário com @csrf.
     */
    public function logout(Request $request)
    {
        //
    }
}
