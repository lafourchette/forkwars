<?php

namespace Forkwars\Scene;

use Forkwars\Position;

/**
 * Scene node. May have a position and a reference.
 */
class Node
{
    private $children = null;

    private $parent = null;

    private $position = null;

    private $reference = null;

    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param Node $parent
     * @return $this
     */
    public function setParent(Node $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Node[]
     */
    public function getChildren()
    {
        if(is_null($this->children)){
            $this->children = new \SplObjectStorage();
        }
        return $this->children;
    }

    /**
     * Add a child to $this and sets the child's parent.
     * @param Node $child
     * @return $this
     */
    public function addChild(Node $child)
    {
        $this->getChildren()->attach($child);
        $child->setParent($this);
        return $this;
    }

    /**
     * Remove the child and makes the child orphan.
     * @param Node $child
     * @return $this
     */
    public function removeChild(Node $child)
    {
        $this->getChildren()->detach($child);
        $child->setParent(null);
        return $this;
    }

    /**
     * @param Node $parent
     * @return $this
     */
    public function attachTo(Node $parent)
    {
        $this->setParent($parent);
        $parent->getChildren()->attach($this);
        return $this;
    }

    /**
     * @return $this
     */
    public function detach()
    {
        $this->getParent()->getChildren()->detach($this);
        $this->setParent(null);
        return $this;
    }

    public function __sleep()
    {
        // Deal with circular references.
        $this->parent = null;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return $this Fluent
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
        return $this;
    }
}