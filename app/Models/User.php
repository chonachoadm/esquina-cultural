<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'mercadopago_user_id',
        'mercadopago_access_token',
        'mercadopago_refresh_token',
        'mercadopago_connected_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function theater()
    {
        return $this->hasOne(Theater::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function plays()
    {
        return $this->belongsToMany(Play::class, 'plays_have_users')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function createdPlays()
    {
        return $this->hasMany(Play::class, 'user_id');
    }

    public function savedPlays()
    {
        return $this->belongsToMany(Play::class, 'users_save_plays')
                    ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function isAdmin()
    {
        return $this->role === 1;
    }

    public function hasMercadoPagoConnected()
    {
        return !empty($this->mercadopago_access_token)
            && !empty($this->mercadopago_user_id)
            && !empty($this->mercadopago_connected_at);
    }

    public function getPurchaseStreak(): int
    {
        $purchases = $this->purchases()
            ->where('status', 'confirmed')
            ->orderByDesc('created_at')
            ->get();

        if ($purchases->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $previousPurchase = null;
        $countedPerformances = [];

        foreach ($purchases as $purchase) {
            if (isset($countedPerformances[$purchase->performance_id])) {
                continue;
            }

            if ($previousPurchase === null) {
                $streak++;
                $previousPurchase = $purchase;
                $countedPerformances[$purchase->performance_id] = true;
                continue;
            }

            if ($purchase->created_at->lt($previousPurchase->created_at->copy()->subMonth())) {
                break;
            }

            $streak++;
            $previousPurchase = $purchase;
            $countedPerformances[$purchase->performance_id] = true;
        }

        return $streak;
    }
}
