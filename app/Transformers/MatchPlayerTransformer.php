<?php
namespace App\Transformers;

use App\{MatchPlayer, Player};

class MatchPlayerTransformer extends Transformer
{
    public function transform(MatchPlayer $matchPlayer): array
    {
        $name     = null;
        $position = null;

        if ($matchPlayer->player) {
            $name     = $matchPlayer->player->name;
            $position = (Player::POSITION_MAP[$matchPlayer->player->position] ?? null);
        }

        return [
            'id'       => $matchPlayer->player_id,
            'number'   => $matchPlayer->number,
            'position' => $position,
            'role'     => $matchPlayer->role,
            'name'     => $name,
        ];
    }
}
