<?php

namespace Forkwars\World;

use Forkwars\Exception\TerrainException;
use Forkwars\General\GeneralInterface;

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
                'code'      => GeneralInterface::NONE,
                'blueCode'  => GeneralInterface::BLUE,
                'redCode'   => GeneralInterface::RED
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
        $className = 'Forkwars\\World\\Terrain\\Terrain';

        // Ability to use other classes. Keeps the code isolated.
        if(isset($this->codeMap[$code]['class'])){
            $className = 'Forkwars\\World\\Terrain\\' . $this->codeMap[$code]['class'];
            unset($this->codeMap[$code]['class']);
        }
        return new $className($this->codeMap[$code]);
    }
}
