<?php

namespace Forkwars\General;

use Forkwars\World\World;

/**
 * This general do nothing.
 */
class InactiveBot extends AbstractGeneral
{
    public function doActions(World $world){}
}