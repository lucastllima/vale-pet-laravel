<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';

    protected $fillable = [
        'descricao', 'status', 'cidade_id', 'user_id', 'situacao', 'nome_animal', 'tipo_animal', 'telefone', 'iswhatsapp', 'sexo_animal', 'idade_animal', 'raca_id',
        'iscastrado', 'isvacinado'
    ];

    public static $rules_api = [
        'descricao' => 'max:400',
        'nome_animal' => 'max:50',
        'telefone' => 'max:20'
    ];

    public static function rules_update_api($id){
        return ['descricao' => 'max:400',
        'nome_animal' => 'max:50',
        'telefone' => 'max:20'];
    }

    public static $messages = [
        // 'descricao.required' => 'O campo descrição precisa ser informado.',
        'descricao.max' => 'O campo sobre deve ter no máximo 400 digitos.',
        
        // 'nome_animal.required' => 'O campo nome do animal precisa ser informado.',
        'nome_animal.max' => 'O campo nome do animal deve ter no máximo 50 digitos.',
        
        'telefone.max' => 'O campo telefone deve ter no máximo 20 digitos.',
        
    ];

    public function imagens()
    {
        return $this->hasMany('App\PostImagem', 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function cidade(){
        return $this->belongsTo('App\Cidade', 'cidade_id', 'id');
    }

    public function raca(){
        // return $this->belongsTo('App\Cidade', 'cidade_id', 'id');
        return $this->hasOne('App\Raca', 'id', 'raca_id');
    }

    // public function imagem()
    // {
    //     // return $this->hasMany('App\PostImagem', 'post_id', 'id')->first();
    //     return $this->imagens()->first();
    // }

    public function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen( $output_file, 'wb' ); 
        fwrite( $ifp, base64_decode( $base64_string ) );
        fclose( $ifp ); 
    
        return $output_file; 
    }
}
