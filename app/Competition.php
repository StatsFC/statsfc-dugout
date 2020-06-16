<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;

class Competition extends Model
{
    protected $casts = [
        'id'      => 'integer',
        'country' => 'string',
        'name'    => 'string',
        'key'     => 'string',
        'enabled' => 'boolean',
    ];

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('enabled', '=', true);
    }

    public function scopeFilterRegion(Builder $query, Request $request): Builder
    {
        if ($region = $request->has('region')) {
            $query->where('competitions.country', '=', $region);
        }

        return $query;
    }

    public function scopeVisibleByCustomer(Builder $query, int $customer_id): Builder
    {
        return $query
            ->enabled()
            ->join('competition_payment', 'competition_payment.competition_id', '=', 'competitions.id')
            ->join('payments', 'payments.id', '=', 'competition_payment.payment_id')
            ->whereRaw('? BETWEEN `payments`.`from` AND `payments`.`to`', [
                Carbon::today()->toDateString(),
            ])
            ->where('payments.customer_id', '=', $customer_id);
    }
}
