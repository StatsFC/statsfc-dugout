<?php
namespace App\Transformers;

use App\Team;

class TeamTransformer extends Transformer
{
    public function transform(Team $team): array
    {
        return [
            'id'        => $team->id,
            'name'      => $team->name,
            'shortName' => $team->short_name,
        ];
    }
}
