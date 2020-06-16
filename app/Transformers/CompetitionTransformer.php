<?php

namespace App\Transformers;

use App\Competition;

class CompetitionTransformer extends Transformer
{
    public function transform(Competition $competition, bool $includeRounds = true): array
    {
        $data = [
            'id'     => $competition->id,
            'name'   => $competition->name,
            'key'    => $competition->key,
            'region' => $competition->country,
        ];

        if ($includeRounds) {
            $data['rounds'] = (new RoundTransformer)->transformCollection($competition->rounds);
        }

        return $data;
    }
}
