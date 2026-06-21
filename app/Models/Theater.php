<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'verification_status',
        'max_capacity',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plays()
    {
        return $this->hasMany(Play::class);
    }

    public function performances()
    {
        return $this->hasManyThrough(Performance::class, Play::class);
    }

    public function getShortAddressAttribute()
    {
        $parts = collect(explode(',', $this->address))
            ->map(fn($p) => trim($p));
    
        return collect([
            ($parts[1] ?? null) . ' ' . ($parts[0] ?? null),
            $parts[2] ?? null
        ])->filter()->implode(', ');
    }
}
