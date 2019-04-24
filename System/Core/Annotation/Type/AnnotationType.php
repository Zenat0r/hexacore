<?php


namespace Hexacore\Core\Annotation\Type;

/**
 * Class AnnotationType
 * @package Hexacore\Core\Annotation\Type
 */
class AnnotationType
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * AnnotationType constructor.
     * @param string $key
     * @param $value
     */
    public function __construct(string $key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}