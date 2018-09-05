<?php

namespace Hexacore\Core\Model;

use Hexacore\Core\Storage\StorageInterface;


class StorableModel implements StorageInterface
{
    private $idField;
    private $fields;
    private $model;

    public function __construct(string $idField, array $storage, AbstractStorageModel $model)
    {
        $this->idField = $idField;
        $this->fields = $storage;
        $this->model = $model;
    }

    public function add(string $name, $value = null)
    {
        $this->fieldExist($name);

        $this->fiedfieldss[$name] = $value ?? $name;

        $this->model->update($this);
    }

    public function remove(string $name) : bool
    {
        $this->fieldExist($name);

        unset($this->fields[$name]);

        $this->model->remove($this);
    }

    public function get(string $name)
    {
        $this->fieldExist($name);

        return $this->fields[$name];
    }

    public function getIdField()
    {
        return $storage[$this->idField];
    }

    public function insert()
    {
        $this->model->insert($this);
    }

    private function fieldExist(string $name)
    {
        if(!array_key_exists($name, $this->fields)){
            throw new \Exception("Filed doesn't exist");
        }
    }
}