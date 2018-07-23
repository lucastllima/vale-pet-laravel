<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImagem extends Model
{
    public $timestamps = false;
    
    protected $table = 'post_imagens';

    protected $fillable = [
        'foto', 'post_id'
    ];

}
