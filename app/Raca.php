<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raca extends Model
{
    public $timestamps = false;
    
    protected $table = 'racas';

    protected $fillable = [
        'nome', 'tipo'
    ];
}
