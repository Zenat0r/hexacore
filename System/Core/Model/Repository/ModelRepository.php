<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 18/03/19
 * Time: 13:32
 */

namespace Hexacore\Core\Model\Repository;


use Hexacore\Core\Model\ManageableModelInterface;
use Hexacore\Core\Model\QueryBuilder;

class ModelRepository
{
    private $qb;

    private $namespace;
    private $model;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->qb = $queryBuilder;
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    private function getIdentificator(): string
    {
        $reflection = new \ReflectionClass($this->namespace);

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($reflexionProperties as $property) {
            if (preg_match("/id$/", $property->getName())) {
                return $property->getName();
            }
        }

        throw new \Exception("Missing ManagableModel identificator");
    }

    /**
     * @param iterable $data
     * @return array|mixed|null
     * @throws \Exception
     */
    private function populateModel(iterable $data)
    {
        if (0 === sizeof($data)) return null;
        else {
            $models = [];

            foreach ($data as $row) {
                $model = new $this->namespace();

                foreach ($row as $key => $elt) {
                    if (!is_null($elt)) {
                        // TODO match class variable name to database filed name
                        $setterName = "set" . ucfirst($key);
                        if (method_exists($this->namespace, $setterName)) {
                            $model->$setterName($elt);
                        } else {
                            throw new \Exception("Setter for $key doesn't exist");
                        }
                    }
                }

                array_push($models, $model);
            }

            return $models;
        }
    }

    public function setModel(string $namespace): ModelRepository
    {
        $this->namespace = $namespace;
        $this->model = array_pop(explode("\\", $namespace));;
        return $this;
    }

    /**
     * @param int $id
     * @return ManageableModelInterface
     * @throws \Exception
     */
    public function findById(int $id): ?ManageableModelInterface
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }

        $result = $this->qb
            ->model($this->model)
            ->where($this->getIdentificator(), $id)
            ->get();

        return reset($this->populateModel($result));
    }

    /**
     * @return array|mixed|null
     * @throws \Exception
     */
    public function findAll()
    {
        if (null == $this->model) {
            throw new \Exception("No model set");
        }

        $result = $this->qb
            ->model($this->model)
            ->get();

        return $this->populateModel($result);
    }
}