<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model};

class MatchPlayer extends Model
{
    const ROLE_STARTING   = 'starting';
    const ROLE_SUBSTITUTE = 'sub';

    protected $table = 'match_player';

    protected $casts = [
        'match_id'  => 'integer',
        'team_id'   => 'integer',
        'player_id' => 'integer',
        'number'    => 'integer',
        'role'      => 'string',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeFilterTeam(Builder $query, int $team_id): Builder
    {
        return $query->where('match_player.team_id', '=', $team_id);
    }

    public function scopeHasRole(Builder $query): Builder
    {
        return $query->whereIn('match_player.role', [
            static::ROLE_STARTING,
            static::ROLE_SUBSTITUTE,
        ]);
    }

    public function scopeOrderByPosition(Builder $query): Builder
    {
        return $query
            ->join('players', 'players.id', '=', 'match_player.player_id')
            ->orderByRaw('FIND_IN_SET(`players`.`position`, "G,D,M,A")')
            ->orderBy('match_player.number');
    }
}
