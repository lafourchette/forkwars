<?php

namespace Forkwars\Game;


class Record
{
    private $turns;

    private $recorded;

    public function __construct()
    {
        $this->recorded = new \DateTime();
        $this->turns = new \SplStack();
    }

    public function addTurn(Turn $turn)
    {
        $this->turns->unshift($turn);
    }

    public function getTurnCount()
    {
        return count($this->turns);
    }


    /**
     * Ok for using in viewer
     */
    public function toJson()
    {
    }

    /**
     * Ok for displaying in terminal
     */
    public function toString()
    {
        $buffer = null;
        foreach($this->turns as $turn){
            $buffer.= 'startTurn' . PHP_EOL;
            foreach($turn as $action){
                $buffer.= "\t" . $action . PHP_EOL;
            }
            $buffer.= 'endTurn' . PHP_EOL;
        }
        return $buffer;
    }
}