<?php

namespace Forkwars\World;

/**
 * An action performed by something.
 */
class Action
{
    private $description;

    private $stringDescription;

    public function __construct(Thing $who, $what, $mixed)
    {
        $this->stringDescription = sprintf('%s %s %s',
            $who->getReference(),
            $what,
            $mixed instanceof Thing ? $this->formatThing($mixed) : var_export($mixed, true)
        );

        $this->description = array(
            'what' => $what,
            'who'  => $this->formatThing($who),
            'target' => $mixed instanceof Thing ? $this->formatThing($mixed) : $mixed,
            'summary' => $this->stringDescription
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

    public function __toString()
    {
        return $this->stringDescription;
    }
}
