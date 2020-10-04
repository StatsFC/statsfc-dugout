<?php
namespace App\Transformers;

use App\Team;

class TeamTransformer extends Transformer
{
    public function transform(Team $team = null): ?array
    {
        if ($team === null) {
            return null;
        }

        return [
            'id'        => $team->id,
            'name'      => $team->name,
            'shortName' => $team->short_name,
        ];
    }
}
