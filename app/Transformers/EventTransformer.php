<?php
namespace App\Transformers;

use App\Event;

class EventTransformer extends Transformer
{
    public function transform(Event $event): array
    {
        switch ($event->type) {
            case Event::TYPE_GOAL:
                return (new GoalTransformer)->transform($event);

            case Event::TYPE_RED_CARD:
            case Event::TYPE_SECOND_YELLOW_CARD:
            case Event::TYPE_YELLOW_CARD:
                return (new CardTransformer)->transform($event);

            case Event::TYPE_SUBSTITUTION:
                return (new SubstitutionTransformer)->transform($event);

            default:
                return [];
        }
    }
}
