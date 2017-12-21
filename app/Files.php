<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    //
    protected $table = 'files';

    public function post(){
        return $this->belongsTo('App\PostModel', 'post_id');
    }
}
