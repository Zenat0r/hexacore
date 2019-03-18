<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:02
 */

namespace Hexacore\Core\Model\ModelManager;

use Hexacore\Core\Model\ManageableModelInterface;
use Hexacore\Core\Model\Manager\ModelManagerInterface;
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
     */
    private function populateQueryBuilder(ManageableModelInterface $model): QueryBuilder
    {
        $namespace = get_class($model);
        $reflection = new \ReflectionClass($namespace);

        $reflexionMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $className = array_pop(explode("\\", $namespace));

        $qb = $this->qb->model($className);

        foreach ($reflexionMethods as $method) {
            $methodName = $method->getName();

            if (preg_match("/^get/", $methodName)) {
                if (!is_null($value = $model->$methodName())) {
                    // TODO match class variable name to database filed name
                    $qb->set(preg_split("/get/", $methodName)[1], $value);
                }
            }
        }

        return $qb;
    }

    /**
     * @param ManageableModelInterface $model
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function update(ManageableModelInterface $model)
    {
        $this->populateQueryBuilder($model)
            ->where("Id", $model->getId())
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
            ->where("Id", $model->getId())
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