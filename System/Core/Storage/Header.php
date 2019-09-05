<?php


namespace Hexacore\Core\Storage;


class Header implements StorageInterface
{
    /**
     * @var array
     */
    private $headers;

    public function __construct()
    {
        $serverData = $_SERVER;

        foreach ($serverData as $key => $value) {
            if (preg_match("/^HTTP_.*$/", $key)) {
                $this->headers[str_replace("HTTP_", "", $key)] = $value;
            } else {
                $this->headers[$key] = $value;
            }
        }
    }

    /**
     * Add an element to the storage system, return value if added otherwise false
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function add(string $name, $value = null)
    {
        $value = $value ?? $name;
        if (isset($this->headers[$name])) {
            return false;
        } else {

            $this->headers[$name] = $value;
            return $value;
        }
    }

    /**
     * Remove an element to the storage system, return true if removed
     *
     * @param string $name
     * @return bool
     */
    public function remove(string $name): bool
    {
        if (isset($this->headers[$name])) {
            unset($this->headers[$name]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return the element or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        return $this->headers[$name] ?? null;
    }
}