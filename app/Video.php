<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    //Relación One To Many -- 1 video puede tener muchos comentarios
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //Relación Muchos a Uno -- Videos de 1 usuario
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
