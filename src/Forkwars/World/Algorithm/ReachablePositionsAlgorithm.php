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
    /**
     * @var Position[] $visited Already visited nodes, dijkstra style.
     */
    private $visited;

    /**
     * Movements left per position. When reach 0, cannot move further.
     * @var \SplObjectStorage $left
     */
    private $left;

    private $world;

    // @todo shall use World and others unit position to compute
    // use a graph flow algo
    public function compute(Unit $unit)
    {
        $this->world = $unit->getWorld();
        $current = $unit->getWorldPosition();

        // init the algorithm
        $this->visited = array();
        $this->left = new \SplObjectStorage();
        $this->left[$current] = $unit->moveCount;

        $this->_recursive($current);

        // Filter $left to get all positions (which are indexes in the storage)
        $reachable = array();
        foreach ($this->left as $position)
        {
            $reachable[] = $position;
        }

        return $reachable;
    }

    private function _recursive(Position $pos)
    {
        if (in_array($pos, $this->visited)) {
            return;
        }

        // Get the current movements left.
        $moveLeft = $this->left[$pos];
        if ($moveLeft <= 0) {
            return;
        }

        // Compute for neighboring positions
        $positions = $this->world->getNeighboringPositions($pos);
        foreach ($positions as $p) {
            if (in_array($p, $this->visited)) {
                continue;
            }
            $terrain = $this->world->getTerrain($p);
            $prevMoveLeft = isset($this->left[$p]) ? $this->left[$p] : -1;
            $newMoveLeft = $moveLeft - $terrain->footCost;
            // Keep only the greedier move left
            if ($newMoveLeft > $prevMoveLeft) {
                $this->left[$p] = $newMoveLeft;
            }
        }

        // Mark as visited.
        array_push($this->visited, $pos);

        // Recurse on remaining nodes.
        foreach ($positions as $p) {
           $this->_recursive($p);
        }
    }
}
