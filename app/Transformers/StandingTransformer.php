<?php
namespace App\Transformers;

use App\Standing;

class StandingTransformer extends Transformer
{
    public function transform(Standing $standing): array
    {
        return [
            'season'      => (new SeasonTransformer)->transform($standing->season),
            'competition' => (new CompetitionTransformer)->transform($standing->competition, false),
            'group'       => $standing->group_name,
            'team'        => (new TeamTransformer)->transform($standing->team),
            'position'    => $standing->position,
            'played'      => $standing->played,
            'wins'        => $standing->won,
            'draws'       => $standing->drawn,
            'losses'      => $standing->lost,
            'for'         => $standing->goals_for,
            'against'     => $standing->goals_against,
            'difference'  => $standing->goal_difference,
            'points'      => $standing->points,
            'notes'       => $standing->description,
        ];
    }
}
