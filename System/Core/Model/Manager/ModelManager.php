<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:02
 */

namespace Hexacore\Core\Model\Manager;

use Hexacore\Core\Model\ManageableModelInterface;
use Hexacore\Core\Model\QueryBuilder;

/**
 * Class ModelManager
 * @package Hexacore\Core\Model\ModelManager
 */
class ModelManager implements ModelManagerInterface
{
    /**
     * @var QueryBuilder
     */
    private $qb;

    /**
     * ModelManager constructor.
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @param ManageableModelInterface $model
     * @return QueryBuilder
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function populateQueryBuilder(ManageableModelInterface $model): QueryBuilder
    {
        $namespace = get_class($model);
        $reflection = new \ReflectionClass($namespace);

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        $className = array_pop(explode("\\", $namespace));

        $qb = $this->qb->model($className);

        foreach ($reflexionProperties as $property) {
            $propertyName = $property->getName();
            $getterName = "get" . ucfirst($propertyName);

            if (method_exists($model, $getterName)) {
                if (!is_null($value = $model->$getterName())) {
                    // TODO match class variable name to database filed name
                    $qb->set($propertyName, $value);
                }
            } else {
                throw new \Exception("Getter for $propertyName doesn't exist");
            }
        }

        return $qb;
    }

    /**
     * @param ManageableModelInterface $model
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function getIdentificator(ManageableModelInterface $model): string
    {
        $namespace = get_class($model);
        $reflection = new \ReflectionClass($namespace);

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($reflexionProperties as $property) {
            if (preg_match("/id$/", $property->getName())) {
                return $property->getName();
            }
        }

        throw new \Exception("Missing ManagableModel identificator");
    }

    /**
     * @param ManageableModelInterface $model
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function update(ManageableModelInterface $model)
    {
        $this->populateQueryBuilder($model)
            ->where($this->getIdentificator($model), $model->getId())
            ->update();
    }

    /**
     * @param ManageableModelInterface $model
     * @throws \Exception
     */
    private function create(ManageableModelInterface $model)
    {
        $this->populateQueryBuilder($model)
            ->insert();
    }

    /**
     * @param ManageableModelInterface $model
     * @throws \Exception
     */
    public function delete(ManageableModelInterface $model)
    {
        $className = array_pop(explode("\\", get_class($model)));

        $this->qb
            ->model($className)
            ->where($this->getIdentificator($model), $model->getId())
            ->delete();
    }

    /**
     * @param ManageableModelInterface $model
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function persist(ManageableModelInterface $model)
    {
        if (!empty($model->getId())) {
            $this->update($model);
        } else {
            $this->create($model);
        }
    }
}