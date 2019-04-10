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
    public function __construct(string $key, $value)
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
     * @param string $key
     * @return AnnotationType
     */
    public function setKey(string $key): AnnotationType
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return AnnotationType
     */
    public function setValue($value): AnnotationType
    {
        $this->value = $value;
        return $this;
    }


}