<?php

namespace Forkwars\WinCondition;

use Forkwars\Game;

class MaxTurn implements WinConditionInterface
{
    private $maxTurn;

    public function __construct($maxTurn)
    {
        $this->maxTurn = $maxTurn;
    }

    public function hasAWinner(Game $game)
    {
        return $game->getRecord()->getTurnCount() >= $this->maxTurn;
    }
} 