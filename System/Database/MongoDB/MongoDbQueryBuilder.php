<?php

namespace Hexacore\Database\MongoDB;

use Hexacore\Core\Exception\Model\ModelException;
use Hexacore\Core\Model\AbstractQueryBuilder;
use Hexacore\Core\Model\QueryBuilderInterface;
use Hexacore\Database\MongoDB\Exception\QueryBuilderException;


class MongoDbQueryBuilder extends AbstractQueryBuilder
{

    const OPERATOR_MAP = [
        '=' => '$eq',
        '<' => '$lt',
        '<=' => '$lte',
        '>' => '$gt',
        '>=' => '$gte',
        'IN' => '$in',
        '<>' => '$ne',
        'LIKE' => '$in'
    ];

    /**
     * @var MongoDbConnection
     */
    protected $connection;

    private $sets;

    private $lastId;
    private $collection;
    private $projection;

    private $where;
    /**
     * @var bool
     */
    private $lastIsAnd;

    /**
     * MongoDbQueryBuilder constructor.
     * @param MongoDbConnection $connection
     */
    public function __construct(MongoDbConnection $connection)
    {
        $this->connection = $connection->establish();
    }

    /**
     * @param $value
     * @param string $operator
     * @return array
     * @throws QueryBuilderException
     */
    private function operatorTransformer($value, string $operator)
    {
        if (!in_array($operator, self::ALLOWED_OPERATOR)) {
            throw new QueryBuilderException("Operator not allowed");
        }

        return [self::OPERATOR_MAP[$operator] => $value];
    }

    private function reset()
    {
        $this->where = null;
        $this->projection = null;
        $this->sets = null;
    }

    /**
     * @inheritdoc
     */
    public function get(int $limit = null, int $offset = 0): iterable
    {
        if (null === $this->collection) {
            throw new ModelException("No model set");
        }

        $options = [];
        if (null !== $this->projection) {
            $options['projection'] = $this->projection;
        }

        if (null !== $limit) {
            $options["limit"] = $limit;
        }

        if (null === $this->where) {
            $this->where = [];
        }


        $result = $this->collection->find($this->where, $options);

        $arrayResult = [];

        foreach ($result as $r) {
            $a = iterator_to_array($r);

            $arrayObject = [];
            foreach ($a as $key => $val) {
                if ($val instanceof \MongoDB\BSON\ObjectId) {
                    $value = (string)$val;
                } else {
                    $value = $val;
                }
                $arrayObject[$key] = $value;
            }

            $arrayResult[] = $arrayObject;
        }

        $this->reset();

        return $arrayResult;
    }

    /**
     * @inheritdoc
     * @throws ModelException
     * @throws QueryBuilderException
     */
    public function insert()
    {
        if (null === $this->collection) {
            throw new ModelException("No model set");
        }

        if (null == $this->sets) {
            throw new QueryBuilderException("no values to insert");
        }

        $insertionResult = $this->collection->insertOne($this->sets);

        $this->lastId = $insertionResult->getInsertedId();

        $this->reset();
    }

    /**
     * @inheritdoc
     * @throws QueryBuilderException
     * @throws ModelException
     */
    public function update()
    {
        if (null === $this->collection) {
            throw new ModelException("No model set");
        }

        if (null == $this->sets) {
            throw new QueryBuilderException("no values to update");
        }

        if (null == $this->where) {
            throw new QueryBuilderException("no where statement");
        }

        $update = ['$set' => $this->sets];

        $this->collection->updateMany($this->where, $update);

        $this->reset();
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if (null === $this->collection) {
            throw new ModelException("No model set");
        }

        if (!empty($this->where)) {
            $this->collection->deleteMany($this->where);

            $this->reset();
        } else {
            throw new QueryBuilderException("Can not delete without where statement");
        }
    }

    /**
     * @inheritdoc
     * @throws QueryBuilderException
     */
    public function where(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        if ("_id" === $selector) {
            $value = new \MongoDB\BSON\ObjectId($value);
        }

        $this->where['$and'][] = [$selector => $this->operatorTransformer($value, $operator)];

        $this->lastIsAnd = true;

        return $this;
    }

    /**
     * @inheritdoc
     * @throws QueryBuilderException
     */
    public function orWhere(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        if (null === $this->lastIsAnd) {
            return $this->where($selector, $value, $operator);
        }

        if ('_id' === $selector) {
            $value = new \MongoDB\BSON\ObjectId($value);
        }

        if ($this->lastIsAnd) {
            $lastFiled = array_pop($this->where['$and']);

            $this->where['$and'][] = ['$or' => [$lastFiled, [$selector => $this->operatorTransformer($value, $operator)]]];
        } else {
            $size = sizeof($this->where['$and']);
            $this->where['$and'][$size - 1][] = [$selector => $this->operatorTransformer($value, $operator)];
        }

        $this->lastIsAnd = false;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): QueryBuilderInterface
    {
        if ("_id" === $name) {
            $value = new \MongoDB\BSON\ObjectId($value);
        }

        $this->sets[$name] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function filter(iterable $fields): QueryBuilderInterface
    {
        $this->projection = $fields;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addFilter($field): QueryBuilderInterface
    {
        $this->projection[$field] = 1;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function model(string $name): QueryBuilderInterface
    {
        $name = array_pop(explode("\\", $name));
        $this->collection = $this->connection->{$name};

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