<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RateLimiter extends Model
{
    protected $casts = [
        'id'          => 'integer',
        'customer_id' => 'integer',
        'calls'       => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
