<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;

class Match extends Model
{
    const STATUS_ABANDONED        = 'Aban.';
    const STATUS_AFTER_EXTRA_TIME = 'AET';
    const STATUS_FULL_TIME        = 'FT';
    const STATUS_PENALTIES        = 'Pen.';
    const STATUS_POSTPONED        = 'Postp.';

    protected $table = 'matches';

    protected $casts = [
        'id'              => 'integer',
        'round_id'        => 'integer',
        'season_id'       => 'integer',
        'competition_id'  => 'integer',
        'group_id'        => 'integer',
        'group_name'      => 'string',
        'home_id'         => 'integer',
        'away_id'         => 'integer',
        'week'            => 'integer',
        'status'          => 'string',
        'home_score'      => 'integer',
        'home_score_ht'   => 'integer',
        'home_score_ft'   => 'integer',
        'home_score_et'   => 'integer',
        'home_score_pens' => 'integer',
        'home_score_agg'  => 'integer',
        'away_score'      => 'integer',
        'away_score_ht'   => 'integer',
        'away_score_ft'   => 'integer',
        'away_score_et'   => 'integer',
        'away_score_pens' => 'integer',
        'away_score_agg'  => 'integer',
    ];

    public function getDates()
    {
        return [
            'start',
            'created_at',
            'updated_at',
        ];
    }

    public function away(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_id');
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class)
            ->orderBy('events.minute')
            ->orderBy('events.extra_minute')
            ->orderBy('events.shootout_order');
    }

    public function home(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_id');
    }

    public function matchPlayers(): HasMany
    {
        return $this->hasMany(MatchPlayer::class)
            ->select('match_player.*')
            ->join('players', 'players.id', '=', 'match_player.player_id')
            ->orderBy('match_player.team_id')
            ->orderByRaw('FIND_IN_SET(`match_player`.`role`, "starting,sub")')
            ->orderByRaw('FIND_IN_SET(`players`.`position`, "G,D,M,A")')
            ->orderBy('match_player.number');
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
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

    public function scopeFilterDates(Builder $query, Request $request): Builder
    {
        if ($request->has('from')) {
            $query->whereRaw('DATE(`matches`.`start`) >= ?', [$request->get('from')]);
        }

        if ($request->has('to')) {
            $query->whereRaw('DATE(`matches`.`start`) <= ?', [$request->get('to')]);
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
            $query->whereRaw('? IN (`matches`.`home_id`, `matches`.`away_id`)', [$request->get('team_id')]);
        } elseif ($request->has('team')) {
            $query
                ->join('teams AS home', 'home.id', '=', 'matches.home_id')
                ->join('teams AS away', 'away.id', '=', 'matches.away_id')
                ->whereRaw('? IN (`home`.`name`, `away`.`name`)', [$request->get('team')]);
        }

        return $query;
    }

    public function scopeHasEnded(Builder $query): Builder
    {
        return $query
            ->whereIn('matches.status', [
                self::STATUS_POSTPONED,
                self::STATUS_FULL_TIME,
                self::STATUS_PENALTIES,
                self::STATUS_AFTER_EXTRA_TIME,
                self::STATUS_ABANDONED,
            ])
            ->whereRaw('DATE(`matches`.`start`) <= ?', [
                Carbon::today()->toDateString(),
            ]);
    }

    public function scopeHasNotEnded(Builder $query): Builder
    {
        return $query
            ->whereNotIn('matches.status', [
                self::STATUS_POSTPONED,
                self::STATUS_FULL_TIME,
                self::STATUS_PENALTIES,
                self::STATUS_AFTER_EXTRA_TIME,
                self::STATUS_ABANDONED,
            ])
            ->whereRaw('DATE(`matches`.`start`) >= ?', [
                Carbon::today()->toDateString(),
            ]);
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
