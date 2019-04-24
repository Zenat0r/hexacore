<?php


namespace Hexacore\Tests\Mocks\Model;


use Hexacore\Core\Model\ManageableModelInterface;

class FakeModelWithoutIdMock implements ManageableModelInterface
{

    private $fake;
    private $value;

    public function __construct(int $id = null, $value = null)
    {
        $this->fake = $id;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return 1;
    }

    /**
     * @param mixed $id
     * @return ModelMock
     */
    public function setId(int $id): ManageableModelInterface
    {
        $this->fake = $id;
        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getFake(): int
    {
        return $this->fake;
    }

    /**
     * @param int $fake
     */
    public function setFake(int $fake): void
    {
        $this->fake = $fake;
    }
}