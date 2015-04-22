<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 13/04/15
 * Time: 22:40
 */

namespace Forkwars\World\Unit;


use Forkwars\World\Action;
use Forkwars\World\Thing;

class Metadata
{
    /**
     * @var Thing
     */
    protected $parent;

    /**
     * @var Thing|null
     */
    protected $child;

    /**
     * @var Action
     */
    protected $action;

    function __construct(Thing $parent,Thing $child = null, Action $action = null)
    {
        $this->parent = $parent;
        $this->child = $child;
        $this->action = $action;
    }

    /**
     * @return Thing
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Thing|null
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @return Action
     */
    public function getAction()
    {
        return $this->action;
    }


}