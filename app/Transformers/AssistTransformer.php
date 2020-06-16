<?php
namespace App\Transformers;

use App\Player;

class AssistTransformer extends Transformer
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
