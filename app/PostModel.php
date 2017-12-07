<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';


    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
    
}
