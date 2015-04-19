<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 20/04/2015
 * Time: 00:35
 */

namespace Forkwars\Scene;

/**
 * Holds the whole scene. Tracks the root node and the others. Exposes service to them.
 * Think of it as the container. Aka World. Aka Map.
 */
class Scene
{
    /**
     * Add a single node to a scene
     *
     * @param Node $node
     */
    public function add(Node $node)
    {
        // Attach a node
    }

    /**
     * Add a node and it childrens to the scene
     *
     * @param Node $node
     */
    public function addSubTree(Node $node)
    {

    }
}