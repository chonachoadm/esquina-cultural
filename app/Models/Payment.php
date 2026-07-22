<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'purchase_id',
        'provider',
        'external_id',
        'status',
        'amount',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
