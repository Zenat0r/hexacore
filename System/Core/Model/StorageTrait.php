<?php

namespace Hexacore\Core\Model;

trait StorageTrait
{
    public function newObject(): StorableModel
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($classParams, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);

        return new StorableModel(reset($tableFields), $tableFields, $this);
    }

    public function getObject($uniqId): StorableModel
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($classParams, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);

        $tableFields = $this->getSingle(key($tableFields), $uniqId);
        
        return new StorableModel(key($tableFields), $tableFields, $this);
    }
}