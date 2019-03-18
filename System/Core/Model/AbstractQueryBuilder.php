<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 19/03/19
 * Time: 13:33
 */

namespace Hexacore\Core\Model;


use Hexacore\Core\Model\Connection\ConnectionInterface;

/**
 * Class AbstractQueryBuilder
 * @package Hexacore\Core\Model
 */
abstract class AbstractQueryBuilder implements QueryBuilderInterface
{
    const ALLOWED_OPERATOR = ["LIKE", "=", "<>", "<", "=<", ">", ">=", "IN"];

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $model;

    /**
     * @inheritdoc
     */
    abstract public function get(int $limit = null, int $offset = 0): iterable;

    /**
     * @inheritdoc
     */
    abstract public function insert();

    /**
     * @inheritdoc
     */
    abstract public function update();

    /**
     * @inheritdoc
     */
    abstract public function delete();

    /**
     * @inheritdoc
     */
    abstract public function where(string $selector, $value, string $operator = "="): QueryBuilderInterface;

    /**
     * @inheritdoc
     */
    abstract public function orWhere(string $selector, $value, string $operator = "="): QueryBuilderInterface;

    /**
     * @inheritdoc
     */
    abstract public function set(string $name, $value): QueryBuilderInterface;

    /**
     * @inheritdoc
     */
    abstract public function filter(iterable $fields): QueryBuilderInterface;

    /**
     * @inheritdoc
     */
    abstract public function addFilter($field): QueryBuilderInterface;

    /**
     * @inheritdoc
     */
    abstract public function model(string $name): QueryBuilderInterface;
}