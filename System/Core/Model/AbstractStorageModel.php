<?php

namespace Hexacore\Core\Model;

abstract class AbstractStorageModel extends AbstractModel
{
    public function update(StorableModel $store)
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        $this->where($store->getIdField(), $store->get($store->getIdField()));

        foreach($tableFields as $key => $value){
            $this->set($key, $store->get($key));
        }

        parent::update();
    }

    public function remove(StorableModel $store)
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        $this->where($store->getIdField(), $store->get($store->getIdField()));

        foreach($tableFields as $key => $v){
            $value = $store->get($key);
            if(null == $value){
                $this->set($key, $value);
            }
        }

        parent::update();
    }

    public function insert(StorableModel $store)
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        foreach($tableFields as $key => $value){
            $this->set($key, $store->get($key));
        }

        parent::insert();
    }

    public function newObject(): StorableModel
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        return new StorableModel(reset($tableFields), $tableFields, $this);
    }

    public function getObject($uniqId): StorableModel
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        $this->where(reset($tableFields), $uniqId);
        $tableFields = $this->get();
        
        return new StorableModel(reset($tableFields), $tableFields, $this);
    }
}