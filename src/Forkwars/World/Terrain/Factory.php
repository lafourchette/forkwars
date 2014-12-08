<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Action;
use Forkwars\World\Unit\Unit;

class Factory extends Terrain
{
    /**
     * @param $something
     * @return Unit
     */
    public function make($something)
    {
        $unit = new Unit();
        $this->addChild($unit);
        $this->registerReference($unit);
        $this->registerAction(new Action($this, 'make', $something));
        return $unit;
    }
}
