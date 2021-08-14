<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    //Relación Muchos a Uno -- Comentarios de 1 usuario
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
