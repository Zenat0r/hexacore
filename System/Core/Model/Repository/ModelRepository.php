<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 18/03/19
 * Time: 13:32
 */

namespace Hexacore\Core\Model\Repository;


use Hexacore\Core\Exception\Model\IdentificatorModelException;
use Hexacore\Core\Exception\Model\MissingSetterModelException;
use Hexacore\Core\Exception\Model\ModelException;
use Hexacore\Core\Model\AbstractQueryBuilder;
use Hexacore\Core\Model\ManageableModelInterface;

/**
 * This implementation of ModelRepositoryInterface allow developer to retrieve data form the database.
 * ModelRepository can be extended to match more specific needs.
 *
 * Class ModelRepository
 * @package Hexacore\Core\Model\Repository
 */
class ModelRepository implements ModelRepositoryInterface
{
    /**
     * @var AbstractQueryBuilder
     */
    private $qb;

    /**
     * @var string
     */
    private $model;

    /**
     * ModelRepository constructor.
     * @param AbstractQueryBuilder $queryBuilder
     */
    public function __construct(AbstractQueryBuilder $queryBuilder)
    {
        $this->qb = $queryBuilder;
    }

    /**
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function getIdentificator(): string
    {
        $reflection = new \ReflectionClass($this->model);

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($reflexionProperties as $property) {
            if (preg_match("/id$/", $property->getName())) {
                return $property->getName();
            }
        }

        throw new IdentificatorModelException("Missing ManagableModel identificator");
    }

    /**
     * @param iterable $data
     * @return array|null
     * @throws \Exception
     */
    private function populateModel(iterable $data): ?array
    {
        if (0 === sizeof($data)) {
            return null;
        } else {
            $models = [];

            foreach ($data as $row) {
                $model = new $this->model();

                foreach ($row as $key => $elt) {
                    if (!is_null($elt)) {
                        $setterName = "set" . ucfirst($key);
                        if (method_exists($this->model, $setterName)) {
                            $model->$setterName($elt);
                        } else {
                            throw new MissingSetterModelException("Setter for $key doesn't exist");
                        }
                    }
                }

                array_push($models, $model);
            }

            return $models;
        }
    }

    /**
     * @inheritdoc
     */
    public function setModel(string $namespace): ModelRepository
    {
        $this->model = $namespace;
        $this->qb->model($namespace);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id): ?ManageableModelInterface
    {
        if (null == $this->model) {
            throw new ModelException("No model set");
        }

        $result = $this->qb
            ->where($this->getIdentificator(), $id)
            ->get();

        $models = $this->populateModel($result);

        if (null === $models) {
            return null;
        }

        return reset($models);
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function findAll()
    {
        if (null == $this->model) {
            throw new ModelException("No model set");
        }

        $result = $this->qb
            ->get();

        return $this->populateModel($result);
    }
}