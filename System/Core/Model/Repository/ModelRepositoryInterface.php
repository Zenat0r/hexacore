<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 19/03/19
 * Time: 16:22
 */

namespace Hexacore\Core\Model\Repository;


use Hexacore\Core\Model\ManageableModelInterface;

/**
 * Repository a responsible for retrieving data from the database.
 *
 * Interface ModelRepositoryInterface
 * @package Hexacore\Core\Model\Repository
 */
interface ModelRepositoryInterface
{
    /**
     * @param string $namespace
     * @return ModelRepository
     */
    public function setModel(string $namespace): ModelRepository;

    /**
     * @param int $id
     * @return ManageableModelInterface
     * @throws \Exception
     */
    public function findById($id): ?ManageableModelInterface;

    /**
     * @return array|mixed|null
     * @throws \Exception
     */
    public function findAll();
}