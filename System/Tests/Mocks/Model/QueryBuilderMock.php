<?php


namespace Hexacore\Tests\Mocks\Model;


use Hexacore\Core\Model\AbstractQueryBuilder;
use Hexacore\Core\Model\QueryBuilderInterface;

class QueryBuilderMock extends AbstractQueryBuilder
{

    private $data = [
        0 => [
            "id" => 1,
            "value" => "john"
        ],
        1 => [
            "id" => 2,
            "value" => "wick"
        ]
    ];

    public $create;
    public $update;
    public $delete;

    private $select;
    private $where;

    /**
     * @inheritdoc
     */
    public function get(int $limit = null, int $offset = 0): iterable
    {
        if (null === $this->where) {
            return $this->data;
        } else {
            foreach ($this->data as $model) {
                $key = $this->select;

                if (isset($model[$key]) && $model[$key] === $this->where) {
                    $this->select = null;
                    $this->where = null;

                    return [$model];
                }
            }
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function insert()
    {
        $this->create = true;
    }

    /**
     * @inheritdoc
     */
    public function update()
    {
        $this->update = true;
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $this->delete = true;
    }

    /**
     * @inheritdoc
     */
    public function where(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        $this->select = $selector;
        $this->where = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function orWhere(string $selector, $value, string $operator = "="): QueryBuilderInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): QueryBuilderInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function filter(iterable $fields): QueryBuilderInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addFilter($field): QueryBuilderInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function model(string $name): QueryBuilderInterface
    {
        return $this;
    }
}