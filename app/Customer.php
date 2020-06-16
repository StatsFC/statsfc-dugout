<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $casts = [
        'id'                  => 'integer',
        'ip'                  => 'string',
        'lift_ip_restriction' => 'boolean',
    ];

    public function rateLimiters(): HasMany
    {
        return $this->hasMany(RateLimiter::class);
    }

    public function competitionIds()
    {
        return Competition::query()
            ->select('competitions.id')
            ->join('competition_payment', 'competition_payment.competition_id', '=', 'competitions.id')
            ->join('payments', 'payments.id', '=', 'competition_payment.payment_id')
            ->where('payments.customer_id', '=', $this->id)
            ->where('payments.type', '=', 'API')
            ->where('payments.from', '<=', Carbon::today()->toDateString())
            ->where('payments.to', '>=', Carbon::today()->toDateString())
            ->where('competitions.enabled', '=', true)
            ->pluck('id')
            ->toArray();
    }

    public function dailyRateLimit(): ?int
    {
        $payment = Payment::query()
            ->select('daily_rate_limit')
            ->where('customer_id', '=', $this->id)
            ->where('type', '=', 'API')
            ->where('from', '<=', Carbon::today()->toDateString())
            ->where('to', '>=', Carbon::today()->toDateString())
            ->first();

        if (! $payment) {
            return null;
        }

        return $payment->daily_rate_limit;
    }
}
