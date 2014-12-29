<?php

namespace Forkwars\World;

/**
 * An action performed by something.
 */
class Action
{
    private $description;

    public function __construct(Thing $who, $what, $mixed)
    {
        $this->description = array(
            'what' => $what,
            'who'  => $this->formatThing($who),
            'target' => $mixed instanceof Thing ? $this->formatThing($mixed) : $mixed
        );
    }

    private function formatThing(Thing $thing)
    {
        return array(
                'reference' => 't:' . $thing->getReference(),
                'x' => $thing->getPosition()->x,
                'y' => $thing->getPosition()->y,
                'code' => $thing->getName()
            );
    }

    public function getDescription()
    {
        return $this->description;
    }
}
