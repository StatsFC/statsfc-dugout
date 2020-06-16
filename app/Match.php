<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\HasMany};
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

    public function hasEnded(): bool
    {
        return in_array($this->status, [
            self::STATUS_POSTPONED,
            self::STATUS_FULL_TIME,
            self::STATUS_PENALTIES,
            self::STATUS_AFTER_EXTRA_TIME,
            self::STATUS_ABANDONED,
        ]);
    }

    public function away(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_id');
    }

    public function cards(): Builder
    {
        return $this->events()->whereIn('events.type', [
            Event::TYPE_RED_CARD,
            Event::TYPE_SECOND_YELLOW_CARD,
            Event::TYPE_YELLOW_CARD,
        ]);
    }

    public function goals(): Builder
    {
        return $this->events()->where('events.type', '=', Event::TYPE_GOAL);
    }

    public function home(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_id');
    }

    public function matchPlayers(): HasMany
    {
        return $this->hasMany(MatchPlayer::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function substitutions(): Builder
    {
        return $this->events()->where('events.type', '=', Event::TYPE_SUBSTITUTION);
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

    public function scopeFilterDates(Builder $query, Request $request): Builder
    {
        if ($from = $request->has('from')) {
            $query->whereRaw('DATE(`matches`.`start`) >= ?', [$from]);
        }

        if ($to = $request->has('to')) {
            $query->whereRaw('DATE(`matches`.`start`) <= ?', [$to]);
        }

        return $query;
    }

    public function scopeFilterSeason(Builder $query, Request $request): Builder
    {
        if ($id = $request->has('season_id')) {
            $query->where('matches.season_id', '=', $id);
        } elseif ($name = $request->has('season')) {
            $query->join('seasons', 'seasons.id', '=', 'matches.season_id')
                ->where('seasons.name', '=', $name);
        }

        return $query;
    }

    public function scopeFilterTeam(Builder $query, Request $request): Builder
    {
        if ($id = $request->has('team_id')) {
            $query->whereRaw('? IN (`matches`.`home_id`, `matches`.`away_id`)', [$id]);
        } elseif ($name = $request->has('team')) {
            $query
                ->join('teams AS home', 'home.id', '=', 'matches.home_id')
                ->join('teams AS away', 'away.id', '=', 'matches.away_id')
                ->whereRaw('? IN (`home`.`name`, `away`.`name`)', [$name]);
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
