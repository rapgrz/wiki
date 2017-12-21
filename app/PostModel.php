<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;


class PostModel extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    //use Searchable;
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
        return $this->hasMany('App\Comment', 'post_id');
    }
    public function files()
    {
        return $this->hasMany('App\Files', 'post_id');
    }
}
