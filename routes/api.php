<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'Api\AuthController@login');
Route::post('/refresh', 'Api\AuthController@refresh');
Route::post('/logout', 'Api\AuthController@logout');
Route::post('/registro', 'Api\AuthController@registro');

Route::group(['middleware' => 'jwt.auth', 'namespace' => 'Api\\'], function() {
    
    # --> Rotas do perfil
    Route::get('/me', 'AuthController@me');
    Route::post('/atualizar-perfil', 'AuthController@atualizar_perfil');
    Route::post('/atualizar-foto-perfil', 'AuthController@atualizar_foto_perfil');
    

    # --> Rotas das postagens
    Route::get('/posts', 'PostController@posts');
    Route::get('/meus-posts/{id}', 'PostController@meus_posts');
    Route::post('/inserir-post', 'PostController@inserir_post');
    Route::post('/alterar-situacao-post/{id}', 'PostController@alterar_situacao_post');
    Route::post('/remover-post/{id}', 'PostController@remover_post');
    Route::post('/atualizar-post/{id}', 'PostController@atualizar_post');
    Route::post('/buscar-post', 'PostController@buscar_post');

    # --> Racas
    Route::get('/obter-racas/{tipo}', 'PostController@obter_racas');

    # --> Cidades
    Route::get('/obter-cidades', 'PostController@obter_cidades');
    
});