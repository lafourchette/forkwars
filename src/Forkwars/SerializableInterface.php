<?php

namespace Forkwars;

/**
 * SerializableInterface classes are ... serializable as arrays, which is more suitable for
 * json encoding than native php serialize() function. As a bonus, you get also a human readable
 * version of the serialized representation.
 */
interface SerializableInterface
{
    /**
     * @return array An array containing the description.
     */
    public function serialize();

    /**
     * @param array $data Result of the serialize function.
     * @return An instance of the current class correctly set.
     */
    public function unserialize(array $data);

    /**
     * @return string Human readable version for the description.
     */
    public function getSummary();
}