<?php

namespace Hexacore\Core\Storage;

interface StorageInterface
{
    /**
     * Add an element to the storage system, return value if added otherwise false
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function add(string $name, $value = null);

    /**
     * Remove an element to the storage system, return true if removed
     *
     * @param string $name
     * @return bool
     */
    public function remove(string $name): bool;

    /**
     * Return the element or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name);
}
