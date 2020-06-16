<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;

abstract class Transformer
{
    public function transformCollection(Collection $items): array
    {
        return array_map([$this, 'transform'], iterator_to_array($items));
    }
}
