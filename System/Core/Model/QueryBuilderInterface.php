<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 19/03/19
 * Time: 13:03
 */

namespace Hexacore\Core\Model;


/**
 * Implementation of this class must make the bridge between Hexacore
 * querybuilder notation and the database technology used.
 *
 * Interface QueryBuilderInterface
 * @package Hexacore\Core\Model
 */
interface QueryBuilderInterface
{
    /**
     * Retrieve from the database.
     * Every call of that function must not have any consequences on the following calls.
     * If the model value is not set (using setModel function for example) this function
     * has to throw an exception.
     *
     *
     * @param int|null $limit
     * @param int $offset
     * @return iterable
     */
    public function get(int $limit = null, int $offset = 0): iterable;

    /**
     * Every call of that function must not have any consequences on the following calls.
     * If the model value is not set (using setModel function for example) this function
     * has to throw an exception.
     *
     *
     * @return mixed
     */
    public function insert();

    /**
     * Every call of that function must not have any consequences on the following calls.
     * If the model value is not set (using setModel function for example) this function
     * has to throw an exception.
     *
     * @return mixed
     */
    public function update();

    /**
     * Every call of that function must not have any consequences on the following calls.
     * If the model value is not set (using setModel function for example) this function
     * has to throw an exception.
     *
     * @return mixed
     */
    public function delete();

    /**
     * @param string $selector
     * @param $value
     * @param string $operator
     * @return QueryBuilderInterface
     */
    public function where(string $selector, $value, string $operator = "="): QueryBuilderInterface;

    /**
     * @param string $selector
     * @param $value
     * @param string $operator
     * @return QueryBuilderInterface
     */
    public function orWhere(string $selector, $value, string $operator = "="): QueryBuilderInterface;

    /**
     * @param string $name
     * @param $value
     * @return QueryBuilderInterface
     */
    public function set(string $name, $value): QueryBuilderInterface;

    /**
     * @param iterable $fields
     * @return QueryBuilderInterface
     */
    public function filter(iterable $fields): QueryBuilderInterface;

    /**
     * @param $field
     * @return QueryBuilderInterface
     */
    public function addFilter($field): QueryBuilderInterface;

    /**
     * @param string $name
     * @return QueryBuilderInterface
     */
    public function model(string $name): QueryBuilderInterface;
}