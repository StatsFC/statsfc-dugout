<?php
namespace App\Transformers;

use App\Season;

class SeasonTransformer extends Transformer
{
    public function transform(Season $season = null): ?array
    {
        if ($season === null) {
            return null;
        }

        return [
            'id'   => $season->id,
            'name' => $season->name,
        ];
    }
}
