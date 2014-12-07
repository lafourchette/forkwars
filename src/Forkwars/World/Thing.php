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
    private $children = null;

    private $parent = null;

    public function setParent(Thing $parent)
    {
        // Remove reference from previous parent
        if($previous = $this->getParent()){
            $previous->removeChild($this);
        }
        $this->parent = $parent;
        // Add new child reference
        $parent->addChild($this);

        return $this;
    }

    /**
     * @return Thing
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function addChild($child)
    {
        $this->getChildren()->attach($child);
    }

    public function removeChild($child)
    {
        $this->getChildren()->detach($child);
    }

    /**
     * @return Thing[]
     */
    public function getChildren()
    {
        if(is_null($this->children)){
            $this->children = new \SplObjectStorage();
        }
        return $this->children;
    }

    public function __sleep()
    {
        // Deal with circular references.
        $this->parent = null;
    }

    public function getPosition()
    {
        throw new \Exception('This thing has no position');
    }

    public function registerAction()
    {
        throw new \Exception('Cannot register action');
    }
}
