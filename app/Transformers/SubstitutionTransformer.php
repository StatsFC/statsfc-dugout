<?php
namespace App\Transformers;

use App\Event;

class SubstitutionTransformer extends Transformer
{
    public function transform(Event $event, bool $includeMatch = false): array
    {
        $data = [
            'id'        => $event->id,
            'matchTime' => $event->matchTime(),
            'type'      => 'substitution',
            'subType'   => null,
        ];

        if ($includeMatch) {
            $data['match_id'] = $event->match_id;
        }

        if ($event->team) {
            $data['team'] = (new TeamTransformer)->transform($event->team);
        }

        if ($event->player && $event->assist) {
            $data['playerOff'] = (new PlayerTransformer)->transform($event->assist);
            $data['playerOn']  = (new PlayerTransformer)->transform($event->player);
        }

        return $data;
    }
}
