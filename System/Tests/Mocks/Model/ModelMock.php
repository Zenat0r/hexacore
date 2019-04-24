<?php


namespace Hexacore\Tests\Mocks\Model;


use Hexacore\Core\Model\ManageableModelInterface;

class ModelMock implements ManageableModelInterface
{

    private $id;
    private $value;

    public function __construct(int $id = null, $value = null)
    {

        $this->id = $id;
        $this->value = $value;
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
     * @return ModelMock
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ModelMock
     */
    public function setId(int $id): ManageableModelInterface
    {
        $this->id = $id;
        return $this;
    }
}