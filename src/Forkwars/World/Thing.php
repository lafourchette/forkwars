<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * A thing is part of a World, got a position on it, and which is sometimes part of a team.
 *
 * Everything is a Thing.
 */
class Thing
{
    private $children = array();

    private $parent = null;

    public function setParent(Thing $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Thing
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Thing[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($mixed)
    {
        $this->children = $mixed;

        // Update parent reference for each Child
        foreach($mixed as $child){
            $child->setParent($this);
        }

        return $this;
    }

    public function __sleep()
    {
        // Deal with circular references.
        $this->parent = null;
    }

    public function getPosition()
    {
        return null;
    }
}
