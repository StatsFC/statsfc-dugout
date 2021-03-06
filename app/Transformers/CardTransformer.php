<?php
namespace App\Transformers;

use App\Event;

class CardTransformer extends Transformer
{
    public function transform(Event $event, bool $includeMatch = false): array
    {
        $data = [
            'id'        => $event->id,
            'matchTime' => $event->matchTime(),
            'type'      => 'card',
            'subType'   => $event->subType(),
        ];

        if ($includeMatch) {
            $data['match_id'] = $event->match_id;
        }

        if ($event->team) {
            $data['team'] = (new TeamTransformer)->transform($event->team);
        }

        if ($event->player) {
            $data['player'] = (new PlayerTransformer)->transform($event->player);
        }

        return $data;
    }
}
