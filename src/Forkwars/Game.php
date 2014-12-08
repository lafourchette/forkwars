<?php

namespace Forkwars;

use Forkwars\General\GeneralInterface;
use Forkwars\WinCondition\WinConditionInterface;
use Forkwars\World\Action;
use Forkwars\World\Game\Record;
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
     * @return Record how the game finished
     */
    public function run()
    {
        while(
            ! $this->generalPlayAndWon($this->redGeneral)
            &&
            ! $this->generalPlayAndWon($this->blueGeneral)
        ){
            // mh this looks dangerous
            sleep(1);
            echo 'arf';
        }

        return $this->getTurns();
    }

    private $turns = array();

    public function getTurns()
    {
        return $this->turns;
    }

    public function generalPlayAndWon(GeneralInterface $general)
    {
        $this->world->startTurn($general);
        $general->doActions($this->world);
        $turn = $this->world->endTurn();
        array_push($this->turns, $turn);
        return $this->winCondition->hasAWinner($this);
    }
}
