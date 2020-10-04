<?php
namespace App\Transformers;

use App\Round;

class RoundTransformer extends Transformer
{
    public function transform(Round $round = null): ?array
    {
        if ($round === null) {
            return null;
        }

        return [
            'id'     => $round->id,
            'name'   => $round->name,
            'season' => (new SeasonTransformer)->transform($round->season),
        ];
    }
}
