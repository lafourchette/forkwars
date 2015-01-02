<?php

namespace Forkwars\WinCondition;

use Forkwars\Game;

/**
 * If one team loose its headquarter.
 */
class MultiCondition implements WinConditionInterface
{
    /**
     * @var WinConditionInterface[]
     */
    private $conditions = null;

    public function __construct()
    {
        $this->conditions = new \SplStack();
        $that = $this;
        array_walk(func_get_args(), function($condition)use($that){
            $that->addCondition($condition);
        });
    }

    public function addCondition(WinConditionInterface $condition)
    {
        $this->conditions->push($condition);
        return $this;
    }

    public function hasAWinner(Game $game)
    {
        $win = false;
        foreach($this->conditions as $condition){
            if($condition->hasAWinner($game)){
                $win = true;
                break;
            }
        }
        return $win;
    }
} 