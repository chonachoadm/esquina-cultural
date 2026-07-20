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

    public function purchases()
    {
        return $this->belongsTo(Purchase::class);
    }
}
