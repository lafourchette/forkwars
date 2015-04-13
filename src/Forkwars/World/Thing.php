<?php

namespace Forkwars\World;

use Forkwars\Position;
use Symfony\Component\Yaml\Exception\RuntimeException;

/**
 * A thing is part of a World, got a position on it, and which is sometimes part of a team.
 *
 * Everything is a Thing.
 */
class Thing
{
    private $children = null;

    private $parent = null;

    private $position = null;

    private $reference = null;

    private $team = null;

    public function getName(){
        throw new \Exception('please give it a name');
    }

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
     * @param null $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return null
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Thing $parent
     * @return $this
     */
    public function setParent(Thing $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return null|Thing
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
        if(is_null($this->children)){
            $this->children = new \SplObjectStorage();
        }
        return $this->children;
    }

    /**
     * Add a child to $this and sets the child's parent.
     * @param Thing $child
     * @return $this
     */
    public function addChild(Thing $child)
    {
        $this->getChildren()->attach($child);
        $child->setParent($this);
        return $this;
    }

    /**
     * Remove the child and makes the child orphan.
     * @param Thing $child
     * @return $this
     */
    public function removeChild(Thing $child)
    {
        $this->getChildren()->detach($child);
        $child->setParent(null);
        return $this;
    }

    /**
     * @param Thing $parent
     * @return $this
     */
    public function attachTo(Thing $parent)
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

    public function getPosition()
    {
        if(is_null($this->position)){
            throw new \Exception('This thing has no position');
        }
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

    public function registerAction(Action $action)
    {
        throw new \Exception('Cannot register action');
    }

    public function registerReference(Thing $thing)
    {
        throw new \Exception('Cannot register reference');
    }

    /**
     * get the root of the Scenegraph
     *
     * @return Thing
     */
    public function getRoot()
    {
        $result = null;
        if (false === $this->isRoot()) {
            if ($this->getParent() === null) {
                throw new RuntimeException('The root thing should be a World.');
            }
            $result = $this->getParent()->getRoot();
        } else {
            $result = $this;
        }
        return $result;
    }

    /**
     * Check if this is the root of the Scenegraph
     *
     * @return bool
     */
    protected function isRoot()
    {
        return ($this->parent === null && $this instanceof World) ? true : false;
    }
}
