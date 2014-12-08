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
        if($mixed instanceof Thing){
            $mixed = 't:' . $mixed->getReference();
        }
        $this->description = sprintf('t:%s %s %s',
            $who->getReference(),
            $what,
            $mixed
        );
    }

    public function getDescription()
    {
        return $this->description;
    }
}
