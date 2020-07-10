<?php
namespace App\Transformers;

use App\{Event, Match, MatchPlayer};

class MatchTransformer extends Transformer
{
    public function transform(Match $match): array
    {
        $homePlayers = [];
        $awayPlayers = [];

        foreach ($match->matchPlayers as $matchPlayer) {
            if (! in_array($matchPlayer->role, [MatchPlayer::ROLE_STARTING, MatchPlayer::ROLE_SUBSTITUTE])) {
                continue;
            }

            switch ($matchPlayer->team_id) {
                case $match->home_id:
                    $homePlayers[] = (new MatchPlayerTransformer)->transform($matchPlayer);
                    break;

                case $match->away_id:
                    $awayPlayers[] = (new MatchPlayerTransformer)->transform($matchPlayer);
                    break;
            }
        }

        $cards         = [];
        $goals         = [];
        $substitutions = [];

        foreach ($match->events as $event) {
            switch ($event->type) {
                case Event::TYPE_RED_CARD:
                case Event::TYPE_SECOND_YELLOW_CARD:
                case Event::TYPE_YELLOW_CARD:
                    $cards[] = (new CardTransformer)->transform($event);
                    break;

                case Event::TYPE_GOAL:
                    $goals[] = (new GoalTransformer)->transform($event);
                    break;

                case Event::TYPE_SUBSTITUTION:
                    $substitutions[] = (new SubstitutionTransformer)->transform($event);
                    break;
            }
        }

        return [
            'id'           => $match->id,
            'timestamp'    => $match->start->toIso8601String(),
            'competition'  => (new CompetitionTransformer)->transform($match->competition, false),
            'round'        => (new RoundTransformer)->transform($match->round),
            'teams'        => [
                'home' => (new TeamTransformer)->transform($match->home),
                'away' => (new TeamTransformer)->transform($match->away),
            ],
            'players'      => [
                'home' => $homePlayers,
                'away' => $awayPlayers,
            ],
            'score'        => [
                $match->home_score,
                $match->away_score,
            ],
            'currentState' => $match->status,
            'events'       => [
                'cards'         => $cards,
                'goals'         => $goals,
                'substitutions' => $substitutions,
            ],
        ];
    }
}
