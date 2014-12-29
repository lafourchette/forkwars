<?php

namespace Forkwars;

/**
 * A two dimensional vector for locating Things on a World.
 */
class Position implements SerializableInterface
{
    public $x, $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function equals(Position $p)
    {
        return ($this->x == $p->x) && ($this->y == $p->y);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return array('x' => $this->x, 'y' => $this->y);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize(array $data)
    {
        return new self($data['x'], $data['y']);
    }

    /**
     * {@inheritdoc}
     */
    public function getSummary()
    {
        return $this->x.'-'.$this->y;
    }
}
