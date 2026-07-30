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
        'user_id',
        'ticket_price',
        'cover_photo',
        'duration',
        'is_published',
        'status',
    ];

    protected $casts = [
        'ticket_price' => 'float',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'users_save_plays')
            ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, Performance::class);
    }

    public function getScheduleShortSlotsAttribute()
    {
        return $this->performances
            ->filter(fn($performance) => $performance->start_time)
            ->map(fn($performance) => [
                'day' => $performance->start_time->locale('es')->isoFormat('ddd'),
                'time' => $performance->start_time->format('H:i'),
            ])
            ->unique(fn($item) => $item['day'] . '-' . $item['time'])
            ->values();
    }
    public function getScheduleSlotsAttribute()
    {
        return $this->performances
            ->filter(fn($performance) => $performance->start_time)
            ->map(fn($performance) => [
                'day' => $performance->start_time->locale('es')->isoFormat('dddd'),
                'time' => $performance->start_time->format('H:i'),
            ])
            ->unique(fn($item) => $item['day'] . '-' . $item['time'])
            ->values();
    }

    public function getIsFinishedAttribute()
    {
        return $this->performances
            ->every(fn($performance) => $performance->start_time->isPast());
    }
}
