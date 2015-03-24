<?php

namespace Forkwars;

use Forkwars\General\GeneralInterface;
use Forkwars\WinCondition\WinConditionInterface;
use Forkwars\Game\Record;
use Forkwars\World\World;

/**
 * Composed of two generals, a world, a winning condition
 */
final class Game
{
    private $world;

    private $redGeneral;

    private $blueGeneral;

    private $winCondition;

    private $record;

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
        $this->record       = new Record($world);
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
            //&&
            //! $this->generalPlayAndWon($this->blueGeneral)
        ){
            // mh this looks dangerous
        }

        return $this->record;
    }

    /**
     * @return Record
     */
    public function getRecord()
    {
        return $this->record;
    }

    public function getWorld()
    {
        return $this->world;
    }

    private $turnCount = 0;

    public function generalPlayAndWon(GeneralInterface $general)
    {
        $this->world->startTurn($general);
        $general->doActions($this->world);
        $turn = $this->world->endTurn();
        $turn->setDay(++$this->turnCount);
        $this->record->addTurn($turn);
        return $this->winCondition->hasAWinner($this);
    }
}
