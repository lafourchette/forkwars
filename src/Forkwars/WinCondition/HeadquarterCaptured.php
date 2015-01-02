<?php

namespace Forkwars\WinCondition;

use Forkwars\Game;

/**
 * If one team loose its headquarter.
 */
class HeadquarterCaptured implements WinConditionInterface
{
    public function hasAWinner(Game $game)
    {
        $teams = array();
        $win = false;
        foreach($game->getWorld()->find('headquarter') as $hq){
            if(! in_array($hq->getTeam(), $teams)){
                array_push($teams, $hq->getTeam());
            }
        }
        var_dump(count($teams), $game->getWorld()->getTeamCount());
        if(count($teams) != ($game->getWorld()->getTeamCount() - 1)){
            $win = true;
        }
        return $win;
    }
} 