<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';

    public function post(){
        return $this->hasMany('App\PostModel');
    }
    public function user(){
        return $this->hasOne('App\PostModel');
    }
}
