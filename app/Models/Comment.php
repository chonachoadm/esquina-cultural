<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'play_id',
        'user_id',
        'comment_body',
    ];

    public function play()
    {
        return $this->belongsTo(Play::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
