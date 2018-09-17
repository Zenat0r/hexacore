<?php

namespace Hexacore\Core\Model;

use Hexacore\Core\Storage\StorageInterface;

class StorableModel implements StorageInterface
{
    private $idField;
    private $fields;
    private $model;

    public function __construct(string $idField, array $storage, AbstractModel $model)
    {
        $this->idField = $idField;
        $this->fields = $storage;
        $this->model = $model;
    }

    public function add(string $name, $value = null)
    {
        $this->fieldExist($name);

        $this->fields[$name] = $value ?? $name;

        $model = $this->model->where($this->idField, $this->fields[$this->idField]);

        $fields = array_diff_key($this->fields, [$this->idField => ""]);
        foreach ($fields as $field => $val) {
            $model->set($field, $val);
        }
        $model->update();
    }

    public function remove(string $name) : bool
    {
        $this->fieldExist($name);

        $this->model->where($this->idField, $this->fields[$this->idField])
                    ->set($this->fields[$name], null)
                    ->update();

        unset($this->fields[$name]);
    }

    public function get(string $name)
    {
        $this->fieldExist($name);

        return $this->fields[$name];
    }

    private function fieldExist(string $name)
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new \Exception("Field doesn't exist");
        }
    }
}
