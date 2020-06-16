<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;

class Team extends Model
{
    protected $casts = [
        'id'         => 'integer',
        'name'       => 'string',
        'short_name' => 'string',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function scopeFilterCompetition(Builder $query, Request $request): Builder
    {
        if ($request->has('competition')) {
            $query->where('competitions.name', '=', $request->get('competition'));
        } elseif ($request->has('competition_id')) {
            $query->where('competitions.id', '=', $request->get('competition_id'));
        } elseif ($request->has('competition_key')) {
            $query->where('competitions.key', '=', $request->get('competition_key'));
        }

        return $query;
    }

    public function scopeFilterSeason(Builder $query, Request $request): Builder
    {
        if ($request->has('season_id')) {
            $query->where('matches.season_id', '=', $request->get('season_id'));
        } elseif ($request->has('season')) {
            $query->join('seasons', 'seasons.id', '=', 'matches.season_id')
                ->where('seasons.name', '=', $request->get('season'));
        }

        return $query;
    }

    public function scopeFilterTeam(Builder $query, Request $request): Builder
    {
        if ($request->has('team_id')) {
            $query->where('teams.id', '=', $request->get('team_id'));
        } elseif ($request->has('team')) {
            $query->where('teams.name', '=', $request->get('team'));
        }

        return $query;
    }

    public function scopeVisibleByCustomer(Builder $query, int $customer_id): Builder
    {
        return $query
            ->join('matches', function (Builder $join) {
                $join->on('teams.id', '=', 'matches.home_id')
                    ->orOn('teams.id', '=', 'matches.away_id');
            })
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
