<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Builder, Model};

class Season extends Model
{
    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
    ];

    public function competitions(): HasMany
    {
        return $this->hasMany(Competition::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(Match::class);
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function scopeVisibleByCustomer(Builder $query, int $customer_id): Builder
    {
        return $query
            ->join('competitions', 'competitions.id', '=', 'matches.competition_id')
            ->join('competition_payment', 'competition_payment.competition_id', '=', 'competitions.id')
            ->join('payments', 'payments.id', '=', 'competition_payment.payment_id')
            ->where('competitions.enabled', '=', true)
            ->whereRaw('? BETWEEN `payments`.`from` AND `payments`.`to`', [
                Carbon::today()->toDateString(),
            ])
            ->where('payments.customer_id', '=', $customer_id);
    }
}
