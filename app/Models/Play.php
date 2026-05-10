<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Play extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'theater_id',
        'ticket_price',
        'cover_photo',
        'duration',
        'is_published',
        'status',
    ];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'plays_have_users')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, Performance::class);
    }
}
