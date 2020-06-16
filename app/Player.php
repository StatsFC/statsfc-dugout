<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Player extends Model
{
    const POSITION_MAP = [
        'A' => 'FW',
        'D' => 'DF',
        'G' => 'GK',
        'M' => 'MF',
    ];

    protected $casts = [
        'id'       => 'integer',
        'team_id'  => 'integer',
        'name'     => 'string',
        'number'   => 'integer',
        'position' => 'string',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
