<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticatedRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function login(AuthenticatedRequest $request)
    {
        //attempt: el user intenta iniciar sesión
        if(!auth()->guard()->attempt($request->only('email', 'password'))){
            throw new AuthenticationException();
        }

        /* $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // this line is important
            return new Response('', 204);  // make sure you return 204
        }

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]); */
    }
}
