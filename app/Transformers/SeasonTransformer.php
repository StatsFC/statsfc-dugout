<?php
namespace App\Transformers;

use App\Season;

class SeasonTransformer extends Transformer
{
    public function transform(Season $season): array
    {
        return [
            'id'   => $season->id,
            'name' => $season->name,
        ];
    }
}
