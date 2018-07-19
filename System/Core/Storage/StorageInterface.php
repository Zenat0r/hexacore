<?php

namespace Hexacore\Core\Storage;

interface StorageInterface
{
    /**
     * Add an element to the storage system, return true if added
     *
     * @param mixed $name
     * @param mixed $value
     * @return boolean
     */
    public function add($name, $value = null) : boolean;

    /**
     * Remove an element to the storage system, returun true if removed
     *
     * @param mixed $name
     * @return boolean
     */
    public function remove($name) : boolean;
    
    /**
     * Return the element or null
     *
     * @param mixec $name
     * @return mixed|null
     */
    public function get($name);
}