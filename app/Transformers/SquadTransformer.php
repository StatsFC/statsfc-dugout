<?php
namespace App\Transformers;

use App\Team;

class SquadTransformer extends Transformer
{
    public function transform(Team $team): array
    {
        return [
            'team'    => (new TeamTransformer)->transform($team),
            'players' => (new PlayerTransformer)->transformCollection($team->players),
        ];
    }
}
