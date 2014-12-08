<?php

namespace Forkwars\General;

use Forkwars\World\World;

abstract class AbstractGeneral implements GeneralInterface
{
    abstract public function doActions(World $world);
}