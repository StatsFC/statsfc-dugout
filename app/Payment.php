<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = [
        'daily_rate_limit' => 'integer',
    ];
}
