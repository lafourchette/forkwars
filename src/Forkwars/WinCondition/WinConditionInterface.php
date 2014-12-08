<?php

namespace Forkwars\WinCondition;

use Forkwars\Game;

interface WinConditionInterface
{
    public function hasAWinner(Game $game);
} 