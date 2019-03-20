<?php

namespace Hexacore\Database\MySql;

use Hexacore\Core\Model\AbstractQueryBuilder;
use Hexacore\Core\Model\QueryBuilderInterface;

/**
 * Implementation of QueryBuilder for the SQL database like.
 *
 * Class QueryBuilder
 * @package Hexacore\Database\MySql
 */
class QueryBuilder extends AbstractQueryBuilder
{
    /**
     * @var string
     */
    private $query;
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $where;

    /**
     * @var array
     */
    private $filter;

    /**
     * @var array
     */
    private $sets;

    /**
     * @var int
     */
    private $lastId;

    /**
     * QueryBuilder constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $query
     * @param array|null $params
     * @return bool|false|\PDOStatement
     */
    private function execute(string $query, ?array $params = null)
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
        $this->filter = null;
        $this->sets = null;

        return $result;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function where(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        if (!in_array($operator, self::ALLOWED_OPERATOR)) {
            throw new \Exception("Operator not allowed");
        }

        if (null == $this->where) {
            $this->where = " WHERE {$selector} {$operator} :where_{$selector}";
        } else {
            $this->where .= " AND {$selector} {$operator} :where_{$selector}";
        }

        $this->params[":where_{$selector}"] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function orWhere(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        if (!in_array($operator, self::ALLOWED_OPERATOR)) {
            throw new \Exception("Operator not allowed");
        }

        if (null == $this->where) {
            $this->where = " WHERE {$selector} {$operator} :orWhere_{$selector}";
        } else {
            $this->where .= " OR {$selector} {$operator} :orWhere_{$selector}";
        }

        $this->params[":orWhere_{$selector}"] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): QueryBuilderInterface
    {
        $this->sets[$name] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function filter(iterable $filter): QueryBuilderInterface
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addFilter($filter): QueryBuilderInterface
    {
        if (is_null($this->filter)) {
            return $this->filter([$filter]);
        } else {
            array_push($this->filter, $filter);
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function get(int $limit = null, int $offset = 0): iterable
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }
        if (null == $this->filter) {
            $this->filter = ["*"];
        }

        $this->query = "SELECT";
        foreach ($this->filter as $field) {
            $this->query .= " {$field},";
        }
        $this->query = substr($this->query, 0, -1);
        $this->query .= " FROM {$this->model}";

        if (!empty($this->where)) {
            $this->query .= $this->where;
        }

        if (!empty($limit)) {
            $this->query .= " LIMIT {$limit} OFFSET {$offset}";
        }

        return $this->execute($this->query, $this->params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function delete()
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }
        $this->query = "DELETE FROM {$this->model}";

        if (!empty($this->where)) {
            $this->query .= $this->where;

            return $this->execute($this->query, $this->params);
        } else {
            throw new \Exception("Can not delete wihout where statement");
        }
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function insert()
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }
        if (null == $this->sets) {
            throw new \Exception("no values to insert");
        }

        $this->query = "INSERT INTO {$this->model}(";

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

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function update()
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }
        if (null == $this->sets) {
            throw new \Exception("no values to update");
        }

        if (null == $this->where) {
            throw new \Exception("Warning: no where statement (add arg false to run anyway)");
        }

        $this->query = "UPDATE {$this->model} SET";

        foreach ($this->sets as $field => $value) {
            $this->query .= " {$field}=:update_{$field}, ";
            $this->params[":update_{$field}"] = $value;
        }

        $this->query = rtrim($this->query, ", ");

        $this->query .= $this->where ?? "";

        return $this->execute($this->query, $this->params);
    }

    /**
     * @inheritdoc
     */
    public function model(string $name): QueryBuilderInterface
    {
        $this->model = array_pop(explode("\\", $name));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastId()
    {
        return $this->lastId;
    }
}
