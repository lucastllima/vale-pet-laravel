<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Response;

use App\User;

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
            return response()->json(['error' => 'Usuário ou senha inválidos!'], 401);
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

    public function registro(Request $r)
    {
        $validator = Validator::make(Input::all(), User::$rules_api, User::$messages);
        if($validator->fails())
        {
            $messages = $validator->messages()->first();
            return response()->json(['error' => $messages], 401);
        }else{
            $user = new User();
            $user->fill($r->all());
            $user->password = bcrypt($r->password);
            $user->save();

            $token = $this->jwtAuth->fromUser($user); //Após cadastrar o usuário eu faço ele logar

            return response()->json(compact('token', 'user'));
        }
        return response()->json($r);
    }

    public function logout()
    {
        $token = $this->jwtAuth->getToken(); //Pega o token do header enviado
        $this->jwtAuth->invalidate($token);

        return response()->json(['success' => 'logout']);
    }
}
