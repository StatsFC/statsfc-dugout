<?php
namespace App\Transformers;

use App\Player;

class PlayerTransformer extends Transformer
{
    public function transform(Player $player): array
    {
        return [
            'id'       => $player->id,
            'name'     => $player->name,
            'position' => (Player::POSITION_MAP[$player->position] ?? null),
        ];
    }
}
