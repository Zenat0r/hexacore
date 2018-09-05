<?php

namespace Hexacore\Core\Model;

use Hexacore\Core\Model\Connection\Connection;

abstract class AbstractModel
{
    const ALLOWED_OPERATOR = ["LIKE", "=", "<>", "<", "=<", ">", ">=", "IN"];
    private $connection;
    protected $table;

    private $query;
    private $params;

    protected $where;

    protected $fields;

    protected $sets;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(string $query, ?array $params = null)
    {
        $connect = $this->connection->establish();
        $connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if (null == $params) {
            $result = $connect->query($query);
        } else {
            $result = $connect->prepare($query);
            $result->execute($params);
        }

        $this->params = null;

        $this->where = null;
        $this->fields = null;
        $this->sets = null;

        return $result->fetchAll();
    }

    public function where(string $selector, $value, string $operator = "="): AbstractModel
    {
        if (!in_array($operator, self::ALLOWED_OPERATOR)) {
            throw new \Exception("Operator not allowed");
        }

        $this->fieldExist($selector);

        if (null == $this->where) {
            $this->where = " WHERE {$selector} {$operator} :where_{$selector}";
        } else {
            $this->where .= " AND {$selector} {$operator} :where_{$selector}";
        }

        $this->params[":where_{$selector}"] = $value;

        return $this;
    }

    public function orWhere(string $selector, $value, string $operator = "="): AbstractModel
    {
        if (!in_array($operator, self::ALLOWED_OPERATOR)) {
            throw new \Exception("Operator not allowed");
        }

        $this->fieldExist($selector);

        if (null == $this->where) {
            $this->where = " WHERE {$selector} {$operator} :orWhere_{$selector}";
        } else {
            $this->where .= " OR {$selector} {$operator} :orWhere_{$selector}";
        }

        $this->params[":orWhere_{$selector}"] = $value;

        return $this;
    }

    public function set(string $name, $value): AbstractModel
    {
        $this->fieldExist($name);

        $this->sets[$name] = $value;

        return $this;
    }

    public function fields(array $fields): AbstractModel
    {
        foreach($fields as $key => $value){
            $this->fieldExist($key);
        }

        $this->fields = $fields;

        return $this;
    }

    public function field(string $field): AbstractModel
    {
        return $this->fields([$field]);
    }

    public function get(): iterable
    {
        if (null == $this->fields) {
            $this->fields = ["*"];
        }

        $this->query = "SELECT";
        foreach ($this->fields as $field) {
            $this->query .= " {$field},";
        }
        $this->query = substr($this->query, 0, -1);
        $this->query .= " FROM {$this->table}";

        if (!empty($this->where)) {
            $this->query .= $this->where;

            return $this->execute($this->query, $this->params);
        } else {
            return $this->execute($this->query);
        }
    }

    public function delete()
    {
        $this->query = "DELETE FROM {$this->table}";

        if (!empty($this->where)) {
            $this->query .= $this->where;

            return $this->execute($this->query, $this->params);
        } else {
            throw new \Exception("Can not delete wihout where statement");
        }
    }

    public function insert(){

        if(null == $this->sets){
            throw new \Exception("no values to insert");
        }

        $this->query = "INSERT INTO {$this->table} (";

        foreach($this->sets as $field => $value){
            $this->query .= "{$field}, ";
        }

        $this->query = substr($this->query, 0, -1) . ")";

        $this->query = " VALUES (";

        foreach($this->sets as $field => $value){
            $this->query .= ":insert_{$field}, ";
            $this->$params[":insert_{$field}"] = $value;
        }

        $this->query = substr($this->query, 0, -1) . ")";

        return $this->execute($this->query, $this->params);
    }

    public function update(bool $withWhere = true)
    {
        if(null == $this->sets){
            throw new \Exception("no values to update");
        }

        if(null == $this->where && $withWhere){
            throw new \Exception("Warning: no where statement (add arg false to run anyway)");
        }

        $this->query = "UPDATE {$this->table} SET";

        foreach($this->sets as $field => $value){
            $this->query .= " {$field}=:update_{$field}";
            $this->params[":update_{$field}"] = $value;
        }

        $this->query .= $this->where ?? "";

        return $this->execute($this->query, $this->params);
    }    

    private function fieldExist(string $name)
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($array_object, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);
        $tableFields = array_filter($array_object, 'strlen');

        if(!in_array($name, $classParams)) throw new \Exception("Field $name doesn' exist");
    }
}
