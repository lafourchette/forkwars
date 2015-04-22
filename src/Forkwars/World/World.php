<?php

namespace Forkwars\World;

use Forkwars\Exception\GameException;
use Forkwars\Game\Turn;
use Forkwars\World\Unit\Unit;
use Forkwars\World\Terrain\Terrain;
use Forkwars\Position;

/**
 * Holds the world representation, root node of the Scenegraph.
 * Has a grid representation of the terrain map.
 *
 * @package Forkwars\World
 */
class World extends Thing
{
    private $name;

    public $width;

    public $height;

    /**
     * @var Terrain[]
     */
    private $grid = array();

    /**
     * @param $name
     * @param $width
     * @param $height
     * @todo limit size
     */
    public function __construct($name, $width, $height)
    {
        $this->name   = $name;
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * Get a terrain on the grid
     *
     * @param Position $position
     * @return Terrain
     */
    public function getTerrainAt(Position $position)
    {
        $i = $this->pos($position);
        return $this->grid[$i];
    }

    /**
     * {@inheritdoc}
     *
     * Store grid representation of terrains.
     */
    public function addChild(Thing $child)
    {
        if(! $child instanceof Terrain){
            throw new \Exception('Cannot attach something else than Terrain to World');
        }

        //@todo

        return parent::addChild($child);
    }

    /**
     * @param $mixed
     * @return false|Thing
     */
    public function findOne($mixed)
    {
        $results = $this->find($mixed);
        return count($results) == 0 ? false : array_shift($results);
    }

    /**
     * @param $mixed
     * @return Thing[]
     */
    public function find($mixed)
    {
        $results = array();
        foreach($this->getChildren() as $t)
        {
            if ($t->getName() == $mixed) {
                array_push($results, $t);
            }

            foreach($t->getChildren() as $t2)
            {
                if ($t2->getName() == $mixed) {
                    array_push($results, $t2);
                }
            }
        }
        return $results;
    }

    private $availableTeams = array();

    public function setAvailableTeams(array $teams)
    {
        $this->availableTeams = $teams;
    }

    public function getTeamCount()
    {
        return count($this->availableTeams);
    }

    public function getTeamByConstant($teamConstant)
    {
        if(! isset($this->availableTeams[$teamConstant])){
            throw new \Exception('cannot find a team for ' . $teamConstant);
        }
        return  $this->availableTeams[$teamConstant];
    }

    /**
     * Helper function to find direct neighboring positions, accounting for borders.
     *
     * @param Position $position
     * @return Position[]
     */
    public function getNeighboringPositions(Position $position)
    {
        $n = clone $position; $n->y--;
        $s = clone $position; $s->y++;
        $w = clone $position; $w->x--;
        $e = clone $position; $e->x++;

        $world = $this;

        return array_filter(array($n, $s, $w, $e), function (Position $p) use ($world) {
            return ! ( $p->y < 0 || $world->height < $p->y ||
                $p->x < 0 || $world->width < $p->x );
        });
    }

    /**
     * Linearize 2 dimensions position for performance issues.
     *
     * @param $x
     * @param null $y
     * @return mixed
     * @throws \Exception
     */
    private function pos($x, $y = null)
    {
        if ($x instanceof Position) {
            $y = $x->y;
            $x = $x->x;
        } elseif (is_null($y)) {
            throw new \Exception('Please set y');
        }
        if($x < 0 || $x < $this->width ){
            throw new \Exception('x is out of bounds');
        }
        if($y < 0 || $y < $this->height ){
            throw new \Exception('y is out of bounds');
        }

        return $x + $this->width * $y;
    }

    /**
     * @var \Forkwars\Game\Turn
     */
    private $currentTurn = null;

    public function startTurn()
    {
        if(! is_null($this->currentTurn)){
            throw new GameException('Please first finish the current turn');
        }
        $this->currentTurn = new Turn();
    }

    public function endTurn()
    {
        $turn = $this->currentTurn;
        $this->currentTurn = null;
        return $turn;
    }

    /**
     * @param Action $action
     * @return $this|void
     * @throws \Exception
     */
    public function registerAction(Action $action)
    {
        if(is_null($this->currentTurn)){
            throw new GameException('Please start turn first');
        }
        $this->currentTurn->unshift($action->getDescription());
        return $this;
    }

    private $referenceCounter = 0;

    private $referenceMap = array();

    public function toArray()
    {
        $buffer = array();
        foreach($this->getChildren() as $t)
        {
            $buffer[] = array(
                'code' => $t->getName() . $t->getTeam(),
                'ref'  => 't:' . $t->getReference(),
                'x' => $t->getPosition()->x,
                'y' => $t->getPosition()->y
            );
        }
        return $buffer;
    }

    /**
     * @param Action $action
     * @return $this|void
     * @throws \Exception
     */
    public function registerReference(Thing $thing)
    {
        $thing->setReference($thing->getName() . '_' . ++$this->referenceCounter);
        array_push($this->referenceMap, $thing->getReference());
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}
