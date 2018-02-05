<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $with = ['user'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    public function user()
    {
        //return $this->belongsTo(User::class);
        return $this->belongsTo('App\Models\User','userid','id');
    }

//    public function user($user_id)
//    {
//        $user = User::find($user_id);
//        return $user;
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'description',
        'userid',
        'date',
    ];
}
