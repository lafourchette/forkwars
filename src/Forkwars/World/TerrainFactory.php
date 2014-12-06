<?php

namespace Forkwars\World;

use Forkwars\World\Terrain\Terrain;
use Forkwars\Exception\TerrainException;

/**
 * Given a description file, makes a terrain given a code.
 */
class TerrainFactory
{
    private $codeMap;

    /**
     * @todo make description an array of objects
     * @todo this ctor is really complicated to understand
     * @param array $description
     */
    public function __construct(array $description)
    {
        // compute a reverse mapping, along with variations.
        foreach ($description as $d) {
            $metadata = $d;
            $codes = array(
                'code'      => Team::TEAM_NONE,
                'blueCode'  => Team::TEAM_BLUE,
                'redCode'   => Team::TEAM_RED
            );
            array_walk(array_keys($codes), function($c) use (&$metadata) {
                unset($metadata[$c]); // remove metadata code references
            });
            // Map each code to a possible team
            foreach ($codes as $n => $v) {
                if(isset($d[$n])){
                    $code = $d[$n];
                    $this->codeMap[$code] = $metadata;
                    $this->codeMap[$code]['team'] = $v;
                }
            }
        }
    }

    public function make($code)
    {
        if(! isset($this->codeMap[$code])) {
            throw new TerrainException('unknown terrain code ' . $code);
        }

        return new Terrain($this->codeMap[$code]);
    }
}
