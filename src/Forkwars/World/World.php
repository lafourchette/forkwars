<?php

namespace Forkwars\World;

use Forkwars\World\Unit\Unit;
use Forkwars\World\Terrain\Terrain;
use Forkwars\Position;

/**
 * Holds the world representation
 *
 * @package Forkwars\World
 */
class World
{
    private $name;

    public $width;

    public $height;

    private $terrainMap = array();

    private $unitList = array();

    public $day = 0;

    public function __construct($name, $width, $height)
    {
        $this->name = $name;
        $this->width= $width;
        $this->height=$height;
    }

    /**
     * Make something part of the world
     */
    public function registerThing(Thing $thing)
    {

    }

    public function setTerrain(Position $position, Terrain $terrain)
    {
        $this->terrainMap[$this->pos($position)] = $terrain;
        $terrain->setWorldPosition($position);

        return $this;
    }

    public function spawnUnit(Position $position, Unit $unit)
    {
        $this->unitList[] = $unit;

        // Add Unit ?

        $unit->setWorldPosition($position);
        $unit->setWorld($this);
    }

    // mixed can be a string, a class, a name... lot of things, terrain or unit
    // we want to make it natural for a general to find its units
    // team is a integer, 0 = red, 1 = blue
    public function find($mixed, $team)
    {
        // find terrains
        foreach($this->terrainMap as $t)
        {
            $className = get_class($t);
            if (stripos($className, $mixed) !== false &&
                $t->getTeam() == $team) {
                return $t;
            }
        }

        // find units
        foreach($this->unitList as $u)
        {
            $className = get_class($u);
            if (stripos($className, $mixed) !== false &&
                $u->getTeam() == $team) {
                return $u;
            }
        }

        return false;
    }

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

    public function getUnitAt(Position $position)
    {
        foreach ($this->unitList as $unit) {
            if ($unit->getWorldPosition()->equals($position)) {
                return $unit;
            }
        }

        return false;
    }

    public function getUnits()
    {
        return $this->unitList;
    }

    /**
     * Will fill the entire World with $terrain clone instance.
     *
     * @param  Terrain $terrain
     * @return World   Fluent interface
     */
    public function fillWith(Terrain $terrain)
    {
        for ($x = 0; $x < $this->width; $x++) {
            for ($y = 0; $y < $this->height; $y++) {
                $pos = new Position($x, $y);
                $this->setTerrain($pos, clone $terrain);
            }
        }

        return $this;
    }

    public function getTerrain($position)
    {
        return $this->terrainMap[$this->pos($position)];
    }

    private function pos($x, $y = null)
    {
        if ($x instanceof Position) {
            $y = $x->y;
            $x = $x->x;
        } elseif (is_null($y)) {
            throw new \Exception('Please set y');
        }

        return $x + $this->width * $y;
    }
}
