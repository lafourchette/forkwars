<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 13/04/15
 * Time: 19:14
 */

namespace Forkwars\World\Terrain;


class Metadata 
{
    /**
     * @var string
     */
    protected $code;

    protected $label;

    protected $class;

    function __construct($label, $code, $class = null)
    {
        $this->label = $label;
        $this->code  = $code;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return null
     */
    public function getClass()
    {
        return $this->class;
    }

    public function __toArray()
    {
        return array($this->label => $this->code);
    }
}