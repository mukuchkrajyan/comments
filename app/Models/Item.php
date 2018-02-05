<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'posts';

    public function comments()
    {
        return $this->hasMany(Comment::class);
        //return $this->hasMany('Comment', 'id');
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];
}
