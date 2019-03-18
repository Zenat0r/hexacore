<?php

namespace Hexacore\Core\Model;

use Hexacore\Core\Model\Connection\Connection;

class QueryBuilder
{
    const ALLOWED_OPERATOR = ["LIKE", "=", "<>", "<", "=<", ">", ">=", "IN"];
    private $connection;
    private $table;

    private $query;
    private $params;

    private $lastId;

    protected $where;

    protected $fields;

    protected $sets;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    protected function execute(string $query, ?array $params = null)
    {
        $connect = $this->connection->establish();
        $connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if (null == $params) {
            $result = $connect->query($query);
        } else {
            $result = $connect->prepare($query);
            $result->execute($params);
        }

        $this->lastId = $connect->lastInsertId();

        $this->params = null;

        $this->where = null;
        $this->fields = null;
        $this->sets = null;

        return $result;
    }

    public function where(string $selector, $value, string $operator = "="): QueryBuilder
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

    public function orWhere(string $selector, $value, string $operator = "="): QueryBuilder
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

    public function set(string $name, $value): QueryBuilder
    {
        $this->sets[$name] = $value;

        return $this;
    }

    public function fields(array $fields): QueryBuilder
    {
        foreach ($fields as $key => $value) {
            $this->fieldExist($key);
        }

        $this->fields = $fields;

        return $this;
    }

    public function field(string $field): QueryBuilder
    {
        return $this->fields([$field]);
    }

    public function get(int $limit = null, int $offset = 0): iterable
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
        }

        if (!empty($limit)) {
            $this->query .= " LIMIT {$limit} OFFSET {$offset}";
        }

        return $this->execute($this->query, $this->params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSingle(String $selector, $value)
    {
        $this->fieldExist($selector);

        $this->query = "SELECT * FROM {$this->table}";

        $this->query .= " WHERE {$selector}=:get_single_{$selector}";
        $this->params[":get_single_{$selector}"] = $value;

        return reset($this->execute($this->query, $this->params)->fetchAll(\PDO::FETCH_ASSOC));
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

    public function insert()
    {
        if (null == $this->sets) {
            throw new \Exception("no values to insert");
        }

        $this->query = "INSERT INTO {$this->table}(";

        foreach ($this->sets as $field => $value) {
            $this->query .= "{$field}, ";
        }

        $this->query = rtrim($this->query, ", ") . ")";

        $this->query .= " VALUES(";

        foreach ($this->sets as $value) {
            $this->query .= "'{$value}', ";
        }

        $this->query = rtrim($this->query, ", ") . ")";

        return $this->execute($this->query, $this->params);
    }

    public function update(bool $withWhere = true)
    {
        if (null == $this->sets) {
            throw new \Exception("no values to update");
        }

        if (null == $this->where && $withWhere) {
            throw new \Exception("Warning: no where statement (add arg false to run anyway)");
        }

        $this->query = "UPDATE {$this->table} SET";

        foreach ($this->sets as $field => $value) {
            $this->query .= " {$field}=:update_{$field}, ";
            $this->params[":update_{$field}"] = $value;
        }

        $this->query = rtrim($this->query, ", ");

        $this->query .= $this->where ?? "";

        return $this->execute($this->query, $this->params);
    }

    private function fieldExist(string $name)
    {
        $classParams = get_object_vars($this);

        $tableFields = array_diff_key($classParams, ["connection" => '', "table" => '', "query" => '', "params" => '', "fileds" => '', "where" => '', "sets" => '']);

        /*if (!array_key_exists($name, $tableFields)) {
            throw new \Exception("Field $name doesn't exist");
        }*/
    }

    public function getLastId()
    {
        return $this->lastId;
    }

    public function model(string $name): QueryBuilder
    {
        $this->table = $name;

        return $this;
    }
}
