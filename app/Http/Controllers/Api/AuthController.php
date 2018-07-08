<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{

    //Variavel do tipo JWTAuth
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth) //Injeção de dependencia
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function me()
    {

        if (! $user = $this->jwtAuth->parseToken()->authenticate()) {
            return response()->json(['error' => 'user_not_found'], 404);
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function login(Request $r)
    {
        // grab credentials from the request
        $credentials = $r->only('email', 'password');

        if (! $token = $this->jwtAuth->attempt($credentials)) {
            return response()->json(['error' => 'Dados de login inválidos!'], 401);
        }

        $user = $this->jwtAuth->authenticate($token);
        // all good so return the token
        return response()->json(compact('token', 'user'));
    }

    public function refresh()
    {
        $token = $this->jwtAuth->getToken(); //Pega o token do header enviado
        $token = $this->jwtAuth->refresh($token); // Faz o refresh do Token

        return response()->json(compact('token'));
    }

    public function logout()
    {
        $token = $this->jwtAuth->getToken(); //Pega o token do header enviado
        $this->jwtAuth->invalidate($token);

        return response()->json(['logout']);
    }
}
