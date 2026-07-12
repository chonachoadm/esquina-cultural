<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
