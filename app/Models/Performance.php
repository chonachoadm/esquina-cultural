<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'play_id',
        'start_time',
        'price_override',
        'status',
    ];
    protected $casts = [
        'start_time' => 'datetime',
    ];

    public function play()
    {
        return $this->belongsTo(Play::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getAvailableTicketsAttribute()
    {
        return $this->play->theater->max_capacity - $this->purchases()->count();
    }
}
