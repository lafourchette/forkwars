<?php

namespace Forkwars\Game;


use Forkwars\World\World;

class Record
{
    private $turns;

    private $recorded;

    private $world;

    public function __construct(World $world)
    {
        $this->world = $world;
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
    public function toJson($jsonFlags = null)
    {
        $buffer = array();
        foreach($this->turns as $turn)
        {
            $buffer[] = $turn->toArray();
        }
        return json_encode(array(
            'map'   => $this->world->toArray(),
            'turns' => $buffer
        ), $jsonFlags);
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