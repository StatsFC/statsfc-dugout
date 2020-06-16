<?php
namespace App\Transformers;

use App\Round;

class RoundTransformer extends Transformer
{
    public function transform(Round $round): array
    {
        return [
            'id'     => $round->id,
            'name'   => $round->name,
            'season' => (new SeasonTransformer)->transform($round->season),
        ];
    }
}
