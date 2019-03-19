<?php

namespace App\Model;

use Hexacore\Core\Model\ManageableModelInterface;

class User implements ManageableModelInterface
{
    private $id;
    private $name;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ManageableModelInterface
     */
    public function setId(int $id): ManageableModelInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


} 