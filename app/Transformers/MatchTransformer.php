<?php
namespace App\Transformers;

use App\{Event, Match, MatchPlayer};

class MatchTransformer extends Transformer
{
    public function transform(Match $match): array
    {
        $homePlayers = MatchPlayer::query()
            ->where('match_id', '=', $match->id)
            ->where('team_id', '=', $match->home_id)
            ->whereIn('role', [MatchPlayer::ROLE_STARTING, MatchPlayer::ROLE_SUBSTITUTE])
            ->get();

        $awayPlayers = MatchPlayer::query()
            ->where('match_id', '=', $match->id)
            ->where('team_id', '=', $match->away_id)
            ->whereIn('role', [MatchPlayer::ROLE_STARTING, MatchPlayer::ROLE_SUBSTITUTE])
            ->get();

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
                'home' => (new MatchPlayerTransformer)->transformCollection($homePlayers),
                'away' => (new MatchPlayerTransformer)->transformCollection($awayPlayers),
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
