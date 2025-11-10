<?php

namespace S4mpp\Backline\Controllers;

use Exception;
use S4mpp\Backline\Backline;
use S4mpp\LaravelAuthSuite\Login;
use Illuminate\Routing\Controller;
use S4mpp\LaravelAuthSuite\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use S4mpp\LaravelAuthSuite\Requests\AuthRequest;

final class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard(Backline::getGuardName())->check()) {
            return to_route('backline.home.index');
        }

        return view('backline::auth.login');
    }

    public function auth(AuthRequest $request)
    {
        $guard_name = Backline::getGuardName();

        $model = app(Auth::guard($guard_name)->getProvider()->getModel());

        $user = $model->where('email', $request->get('username'))->first();

        if (! $user) {
            throw ValidationException::withMessages(['account_not_found' => 'Conta não encontrada. Verifique.']);
        }

        if(Backline::canDisableUsers() &&  !$user->is_active) {
            throw ValidationException::withMessages(['account_not_active' => 'Conta não está ativa.']);
        }

        $login = new Login($user, $guard_name);

        $authentication = $login->try($request->get('password'), $request->get('remember-me', false));

        if (! $authentication) {
            throw ValidationException::withMessages(['invalid_credentials' => 'E-mail ou senha inválidos. Tente novamente.']);
        }

        return to_route('backline.home.index');
    }

    public function logout()
    {
        $guard_name = Backline::getGuardName();

        (new Logout($guard_name))->handle();

        return to_route('backline.login');
    }
}
