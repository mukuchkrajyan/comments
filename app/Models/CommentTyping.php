<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentTyping extends Model
{
    protected $table = 'comment_typers';

    protected $with = ['user'];

    public function item()
    {
        return $this->belongsTo('App\Models\Item','item_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','userid','id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'userid',
    ];
}
