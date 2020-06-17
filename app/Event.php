<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    const TYPE_GOAL               = 'goal';
    const TYPE_MISSED_PENALTY     = 'pen miss';
    const TYPE_RED_CARD           = 'redcard';
    const TYPE_SECOND_YELLOW_CARD = 'yellowred';
    const TYPE_SUBSTITUTION       = 'subst';
    const TYPE_YELLOW_CARD        = 'yellowcard';

    protected $casts = [
        'id'           => 'integer',
        'match_id'     => 'integer',
        'team_id'      => 'integer',
        'player_id'    => 'integer',
        'assist_id'    => 'integer',
        'type'         => 'string',
        'minute'       => 'integer',
        'extra_minute' => 'integer',
        'penalty'      => 'boolean',
        'own_goal'     => 'boolean',
        'home_score'   => 'integer',
        'away_score'   => 'integer',
    ];

    public function matchTime(): string
    {
        return $this->minute . ($this->extra_minute ? '+' . $this->extra_minute : '') . "'";
    }

    public function subType(): ?string
    {
        switch ($this->type) {
            case self::TYPE_GOAL:
                if ($this->penalty) {
                    return 'penalty';
                }

                if ($this->own_goal) {
                    return 'own-goal';
                }

                break;

            case self::TYPE_YELLOW_CARD:
                return 'first-yellow';

            case self::TYPE_SECOND_YELLOW_CARD:
                return 'second-yellow';

            case self::TYPE_RED_CARD:
                return 'red';
        }

        return null;
    }

    public function assist(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(Match::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public static function topScorers(): Builder
    {
        return Event::query()
            ->select([
                'players.id',
                'players.name AS player_name',
                'teams.name AS team_name',
                'teams.short_name AS team_short_name',
                DB::raw('COUNT(events.id) AS goals'),
            ])
            ->join('players', 'players.id', '=', 'events.player_id')
            ->join('teams', 'teams.id', '=', 'events.team_id')
            ->join('matches', 'matches.id', '=', 'events.match_id')
            ->where('events.type', '=', self::TYPE_GOAL)
            ->where('events.own_goal', '=', false)
            ->groupBy('players.id')
            ->groupBy('teams.id')
            ->orderBy('goals', 'desc')
            ->orderBy('players.name', 'asc');
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
            $query->where('events.team_id', '=', $request->get('team_id'));
        } elseif ($request->has('team')) {
            $query->where('teams.name', '=', $request->get('team'));
        }

        return $query;
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
