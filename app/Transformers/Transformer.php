<?php

namespace App\Transformers;

abstract class Transformer
{
    public function transformCollection(array $items): array
    {
        return array_map([$this, 'transform'], $items);
    }
}
