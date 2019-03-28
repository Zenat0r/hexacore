<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:02
 */

namespace Hexacore\Core\Model\Manager;

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
    private $qb;

    /**
     * ModelManager constructor.
     * @param AbstractQueryBuilder $qb
     */
    public function __construct(AbstractQueryBuilder $qb)
    {
        $this->qb = $qb;
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

        $qb = $this->qb->model($namespace);

        foreach ($reflexionProperties as $property) {
            $propertyName = $property->getName();
            $getterName = "get" . ucfirst($propertyName);

            if (method_exists($model, $getterName)) {
                if (!is_null($value = $model->$getterName())) {
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
        $reflection = new \ReflectionClass(get_class($model));

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
     * @inheritdoc
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function delete(ManageableModelInterface $model)
    {
        if (empty($model->getId())) {
            throw new \Exception("Can not delete this model, not a populated ManageableModel");
        }

        $this->qb
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