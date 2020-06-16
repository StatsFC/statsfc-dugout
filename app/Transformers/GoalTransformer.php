<?php
namespace App\Transformers;

use App\Event;

class GoalTransformer extends Transformer
{
    public function transform(Event $event): array
    {
        $data = [
            'id'        => $event->id,
            'matchTime' => $event->matchTime(),
            'type'      => 'goal',
            'subType'   => $event->subType(),
        ];

        if ($event->team) {
            $data['team'] = (new TeamTransformer)->transform($event->team);
        }

        if ($event->player) {
            $data['player'] = (new PlayerTransformer)->transform($event->player);
        }

        if ($event->assist) {
            $data['assist'] = (new AssistTransformer)->transform($event->assist);
        }

        return $data;
    }
}
