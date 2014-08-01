<?php

namespace Forkwars\World\Algorithm;

use Forkwars\Position;
use Forkwars\World\Unit\Unit;
use Forkwars\World\World;

/**
 * Compute reachable positions on a World for a given Unit.
 *
 * Thats a dijkstra shortest path like algorithm, we keep just
 * the by product which holds the interesting info.
 */
class ReachablePositionsAlgorithm
{
    // Already compusted positions are stored here
    private $visited;

    // Cost per position. When reach 0, cannot move further.
    // shall be spl object storage
    private $cost;

    private $world;

    // @todo shall use World and others unit position to compute
    // use a graph flow algo
    public function compute(Unit $unit)
    {
        $this->world = $unit->getWorld();
        $current = $unit->getWorldPosition();

        // init the algorithm
        $this->visited = array();
        $this->cost[$current->__toString()] = $unit->moveCount;

        $this->_recursive($current);

        // we shall have now a cost with all reachable positions.
        var_dump($this->cost); die;
    }

    private function _recursive(Position $pos)
    {
        if (in_array($pos, $this->visited)) {
            return;
        }
        // Get the current movements left.
        $moveLeft = $this->cost[$pos->__toString()];
        if ($moveLeft <= 0) {
            return;
        }

        // Compute for neighboring positions
        $positions = $this->world->getNeighboringPositions($pos);
        foreach ($positions as $p) {
            $terrain = $this->world->getTerrain($p);
            $prevMoveLeft = isset($this->cost[$p->__toString()]) ? $this->cost[$p->__toString()] : 0;
            $newMoveLeft = $moveLeft - $terrain->footCost;
            // Keep only the greedier move left
            if ($newMoveLeft > $prevMoveLeft) {
                $this->cost[$p->__toString()] = $newMoveLeft;
            }
        }

        // Mark as visited
        array_push($this->visited, $pos);

        // Recurse on remaining nodes.

        foreach ($positions as $p) {
           // $this->_recursive($p);
        }
    }
}
