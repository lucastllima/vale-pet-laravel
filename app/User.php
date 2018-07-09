<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules_api = [
        'name' => 'required | max:100 | min:3',
        'email' => 'required | email | unique:users',
        'password' => 'required | confirmed | max:20 | min:6',
    ];

    public static function rules_update_api($id){
        return ['name' => 'required',
                'cpf' => 'required',
                'email' => 'required | email | unique:users,email,'.$id];
    }

    public static $messages = [
        'name.required' => 'O campo nome precisa ser informado. Por favor, você pode verificar isso?',
        'name.max' => 'O campo nome deve ter no máximo 100 digitos. Por favor, você pode verificar isso?',
        'name.min' => 'O campo nome deve ter no mínimo 3 digitos. Por favor, você pode verificar isso?',
		'email.required' => 'O campo email precisa ser informado. Por favor, você pode verificar isso?',
        'password.required' => 'O campo senha precisa ser informado. Por favor, você pode verificar isso?',
        'password.confirmed' => 'As senhas estão divergindo.',
        'password.max' => 'O campo senha deve ter no máximo 20 digitos. Por favor, você pode verificar isso?',
        'password.min' => 'O campo senha deve ter no mínimo 6 digitos. Por favor, você pode verificar isso?',
		'email.unique' => 'O e-mail informado já está em uso.'
    ];
}
