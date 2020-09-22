<?php
namespace App\Transformers;

use App\Event;

class ShootoutTransformer extends Transformer
{
    public function transform(Event $event, bool $includeMatch = false): array
    {
        $data = [
            'id'      => $event->id,
            'type'    => 'shootout',
            'subType' => $event->subType(),
            'order'   => $event->shootout_order,
            'score'   => [$event->home_score, $event->away_score],
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
