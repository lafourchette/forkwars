<?php

namespace Forkwars;

use Forkwars\General\GeneralInterface;
use Forkwars\WinCondition\WinConditionInterface;
use Forkwars\World\Game\Result;
use Forkwars\World\World;

/**
 * Composed of two generals, a world, a winning condition
 */
final class Game
{
    const TEAM_BLUE = 'blue';
    const TEAM_RED  = 'red';
    const TEAM_NONE = 'none';

    private $world;

    private $redGeneral;

    private $blueGeneral;

    private $winCondition;

    public function __construct(
        World $world,
        GeneralInterface $redGeneral,
        GeneralInterface $blueGeneral,
        WinConditionInterface $winCondition
    ) {
        $this->world        = $world;
        $this->redGeneral   = $redGeneral;
        $this->blueGeneral  = $blueGeneral;
        $this->winCondition = $winCondition;
    }

    /**
     * Play the game
     *
     * @return Result how the game finished
     */
    public function run()
    {
        $result = new Result();

        // Play the game


        return $result;
    }
}
