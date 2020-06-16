<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;

class Standing extends Model
{
    protected $casts = [
        'id'                 => 'integer',
        'season_id'          => 'integer',
        'competition_id'     => 'integer',
        'group'              => 'string',
        'team_id'            => 'integer',
        'position'           => 'integer',
        'played'             => 'integer',
        'won'                => 'integer',
        'drawn'              => 'integer',
        'lost'               => 'integer',
        'goals_for'          => 'integer',
        'goals_against'      => 'integer',
        'goal_difference'    => 'integer',
        'points'             => 'integer',
        'home_played'        => 'integer',
        'home_won'           => 'integer',
        'home_drawn'         => 'integer',
        'home_lost'          => 'integer',
        'home_goals_for'     => 'integer',
        'home_goals_against' => 'integer',
        'away_played'        => 'integer',
        'away_won'           => 'integer',
        'away_drawn'         => 'integer',
        'away_lost'          => 'integer',
        'away_goals_for'     => 'integer',
        'away_goals_against' => 'integer',
        'status'             => 'string',
        'form'               => 'string',
        'description'        => 'string',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeFilterCompetition(Builder $query, Request $request): Builder
    {
        if ($name = $request->has('competition')) {
            $query->where('competitions.name', '=', $name);
        } elseif ($id = $request->has('competition_id')) {
            $query->where('competitions.id', '=', $id);
        } elseif ($key = $request->has('competition_key')) {
            $query->where('competitions.key', '=', $key);
        }

        return $query;
    }

    public function scopeFilterSeason(Builder $query, Request $request): Builder
    {
        if ($name = $request->has('season')) {
            $query->join('seasons', 'seasons.id', '=', 'standings.season_id')
                ->where('seasons.name', '=', $name);
        }

        return $query;
    }

    public function scopeVisibleByCustomer(Builder $query, int $customer_id): Builder
    {
        return $query
            ->join('competitions', 'competitions.id', '=', 'standings.competition_id')
            ->join('competition_payment', 'competition_payment.competition_id', '=', 'competitions.id')
            ->join('payments', 'payments.id', '=', 'competition_payment.payment_id')
            ->where('competitions.enabled', '=', true)
            ->whereRaw('? BETWEEN `payments`.`from` AND `payments`.`to`', [
                Carbon::today()->toDateString(),
            ])
            ->where('payments.customer_id', '=', $customer_id);
    }
}
