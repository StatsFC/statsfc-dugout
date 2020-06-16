<?php
namespace App\Transformers;

use App\Match;

class MatchTransformer extends Transformer
{
    public function transform(Match $match): array
    {
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
                'home' => (new MatchPlayerTransformer)->transformCollection(
                    $match->matchPlayers()
                        ->hasRole()
                        ->where('team_id', '=', $match->home_id)
                        ->orderByPosition()
                        ->get()
                ),
                'away' => (new MatchPlayerTransformer)->transformCollection(
                    $match->matchPlayers()
                        ->hasRole()
                        ->where('team_id', '=', $match->away_id)
                        ->orderByPosition()
                        ->get()
                ),
            ],
            'score'        => [
                $match->home_score,
                $match->away_score,
            ],
            'currentState' => $match->status,
            'events'       => [
                'cards'         => (new CardTransformer)->transformCollection($match->cards()->get()),
                'goals'         => (new GoalTransformer)->transformCollection($match->goals()->get()),
                'substitutions' => (new SubstitutionTransformer)->transformCollection($match->substitutions()->get()),
            ],
        ];
    }
}
