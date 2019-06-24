<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:02
 */

namespace Hexacore\Core\Model\Manager;

use Hexacore\Core\Exception\Model\IdentificatorModelException;
use Hexacore\Core\Exception\Model\MissingGetterModelException;
use Hexacore\Core\Exception\Model\PopulatedModelException;
use Hexacore\Core\Model\AbstractQueryBuilder;
use Hexacore\Core\Model\ManageableModelInterface;

/**
 * Class ModelManager
 * @package Hexacore\Core\Model\ModelManager
 */
class ModelManager implements ModelManagerInterface
{
    /**
     * @var AbstractQueryBuilder
     */
    private $queryBuilder;

    /**
     * ModelManager constructor.
     * @param AbstractQueryBuilder $qb
     */
    public function __construct(AbstractQueryBuilder $qb)
    {
        $this->queryBuilder = $qb;
    }

    /**
     * @param ManageableModelInterface $model
     * @return AbstractQueryBuilder
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function populateQueryBuilder(ManageableModelInterface $model): AbstractQueryBuilder
    {
        $namespace = get_class($model);
        $reflection = new \ReflectionClass($namespace);

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        $qb = $this->queryBuilder->model($namespace);

        foreach ($reflexionProperties as $property) {
            $propertyName = $property->getName();
            $propertyName = preg_match("/id$/", $propertyName) ? "id" : $propertyName;

            $getterName = "get" . ucfirst($propertyName);

            if (method_exists($model, $getterName)) {
                if (!is_null($value = $model->$getterName())) {
                    $qb->set($propertyName, $value);
                }
            } else {
                throw new MissingGetterModelException("Getter for $propertyName doesn't exist");
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
        $reflection = new \ReflectionClass(get_class($model));

        $reflexionProperties = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($reflexionProperties as $property) {
            if (preg_match("/id$/", $property->getName())) {
                return $property->getName();
            }
        }

        throw new IdentificatorModelException("Missing ManagableModel identificator");
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
     * @inheritdoc
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function delete(ManageableModelInterface $model)
    {
        if (empty($model->getId())) {
            throw new PopulatedModelException("Can not delete this model, not a populated ManageableModel");
        }

        $this->queryBuilder
            ->model(get_class($model))
            ->where($this->getIdentificator($model), $model->getId())
            ->delete();
    }

    /**
     * @inheritdoc
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