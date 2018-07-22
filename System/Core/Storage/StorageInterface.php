<?php

namespace Hexacore\Core\Storage;

interface StorageInterface
{
    /**
     * Add an element to the storage system, return value if added otherwise false
     *
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     */
    public function add($name, $value = null);

    /**
     * Remove an element to the storage system, returun true if removed
     *
     * @param mixed $name
     * @return bool
     */
    public function remove($name) : bool;

    /**
     * Return the element or null
     *
     * @param mixed $name
     * @return mixed|null
     */
    public function get($name);
}
